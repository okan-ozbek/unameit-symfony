<?php

namespace App\Service;

use App\Entity\Task;
use App\Repository\TaskRepository;

readonly class TaskService
{
    public function __construct(private TaskRepository $taskRepository)
    {

    }

    public function fetchAll(): array
    {
        return $this->taskRepository->fetchAll();
    }

    public function fetchById(int $id): ?Task
    {
        return $this->taskRepository->fetchById($id);
    }

    public function create(Task $task): Task
    {
        $this->taskRepository->save($task, true);
        return $task;
    }

    public function update(Task $task): Task
    {
        $this->taskRepository->save($task, true);
        return $task;
    }

    public function delete(Task $task): void
    {
        $this->taskRepository->remove($task, true);
    }
}
