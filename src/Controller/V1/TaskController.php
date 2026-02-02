<?php

namespace App\Controller\V1;

use App\Entity\Task;
use App\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class TaskController extends AbstractController
{
    public function __construct(private readonly TaskService $taskService) {

    }

    #[Route(path: '/v1/tasks', name: 'v1_tasks', methods: ['GET'])]
    public function index(): Response
    {
        $tasks = $this->taskService->fetchAll();

        if ($tasks === []) {
            return $this->json(['message' => 'No tasks found.'], Response::HTTP_NO_CONTENT);
        }

        return $this->json(['tasks' => $tasks], Response::HTTP_OK);
    }

    #[Route(path: '/v1/tasks/{id}', name: 'v1_task', methods: ['GET'])]
    public function show(int $id): Response
    {
        $task = $this->taskService->fetchById($id);

        if ($task === null) {
            return $this->json(['message' => 'Task not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json(['task' => $task], Response::HTTP_OK);
    }

    #[Route(path: '/v1/tasks', name: 'v1_tasks', methods: ['POST'])]
    public function store(
        #[MapRequestPayload] Task $task
    ): Response
    {
        try {
            $task = $this->taskService->create($task);
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json(['task' => $task], Response::HTTP_CREATED);
    }

    #[Route(path: '/v1/tasks/{id}', name: 'v1_task', methods: ['PATCH'])]
    public function update(
        int $id, #[MapRequestPayload] Task $task
    ): Response
    {
        try {
            $this->taskService->update($task);
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json(['message' => 'Task was successfully updated.'], Response::HTTP_OK);
    }

    #[Route(path: '/v1/tasks/{id}', name: 'v1_task', methods: ['PUT'])]
    public function destroy($id): Response
    {
        try {
            $this->taskService->delete($id);
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json(['message' => 'Task was successfully deleted.'], Response::HTTP_OK);
    }
}
