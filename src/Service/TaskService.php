<?php

namespace App\Service;

use App\Entity\Task;
use App\Enum\TaskStatus;
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

    public function create(Task $task): Task|null
    {
        if ($task->getStatus() === null) {
            $task->setStatus(TaskStatus::PENDING);
        }

        if ($this->statusDoneWithPastDueDate($task)) {
            // Would replace with something such as custom exception in real project
            return null;
        }

        $this->taskRepository->save($task, true);
        return $task;
    }

    public function update(Task $task): Task|null
    {
        $this->taskRepository->save($task, true);

        if ($this->statusDoneWithPastDueDate($task)) {
            // Would replace with something such as custom exception in real project
            return null;
        }

        return $task;
    }

    public function delete(Task $task): void
    {
        $this->taskRepository->remove($task, true);
    }

    private function statusDoneWithPastDueDate(Task $task): bool
    {
        return $task->getStatus() === TaskStatus::DONE && $task->getDueDate() !== null && $task->getDueDate() < new \DateTime();
    }
}
