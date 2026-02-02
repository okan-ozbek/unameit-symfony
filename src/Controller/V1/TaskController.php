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
    public function show(?Task $task): Response
    {
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

            if ($task === null) {
                return $this->json(['message' => 'Task due date cannot be in the past'], Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json(['task' => $task], Response::HTTP_CREATED);
    }

    #[Route(path: '/v1/tasks/{id}', name: 'v1_task', methods: ['PATCH'])]
    public function update(
        ?Task $task, #[MapRequestPayload] Task $payload
    ): Response
    {
        if ($task === null) {
            return $this->json(['message' => 'Task not found'], Response::HTTP_NOT_FOUND);
        }

        try {
            $task = $this->taskService->update($payload);

            if ($task === null) {
                return $this->json(['message' => 'Task due date cannot be in the past'], Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json(['message' => 'Task was successfully updated.'], Response::HTTP_OK);
    }

    #[Route(path: '/v1/tasks/{id}', name: 'v1_task', methods: ['PUT'])]
    public function destroy(?Task $task): Response
    {
        if ($task === null) {
            $this->json(['message' => 'Task was successfully deleted.'], Response::HTTP_OK);
        }

        try {
            $this->taskService->delete($task);
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json(['message' => 'Task was successfully deleted.'], Response::HTTP_OK);
    }
}
