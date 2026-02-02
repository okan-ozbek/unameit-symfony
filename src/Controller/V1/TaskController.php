<?php

namespace App\Controller\V1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TaskController extends AbstractController
{
    #[Route(path: '/v1/tasks', name: 'v1_tasks', methods: ['GET'])]
    public function index(): Response
    {
        return $this->json(['message' => 'Hello world'], Response::HTTP_OK);
    }

    #[Route(path: '/v1/tasks/{id}', name: 'v1_task', methods: ['GET'])]
    public function show(int $id): Response
    {
        return $this->json(['message' => 'Hello world'], Response::HTTP_OK);
    }

    #[Route(path: '/v1/tasks', name: 'v1_tasks', methods: ['POST'])]
    public function store(): Response
    {
        return $this->json(['message' => 'Hello world'], Response::HTTP_CREATED);
    }

    #[Route(path: '/v1/tasks/{id}', name: 'v1_task', methods: ['PATCH'])]
    public function update($id): Response
    {
        return $this->json(['message' => 'Hello world'], Response::HTTP_OK);
    }

    #[Route(path: '/v1/tasks/{id}', name: 'v1_task', methods: ['PUT'])]
    public function destroy($id): Response
    {
        return $this->json(['message' => 'Hello world'], Response::HTTP_OK);
    }


}
