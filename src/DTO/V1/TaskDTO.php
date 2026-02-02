<?php

namespace App\DTO\V1;

use App\Entity\Task;
use App\Enum\TaskStatus;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

class TaskDTO
{
    public function __construct(
        #[Assert\NotBlank(message: "The title cannot be blank.")]
        public string $title,

        #[Assert\Type('string', message: "The description must be a string.")]
        #[Assert\Length(max: 1000, maxMessage: "The description cannot be longer than {{ limit }} characters.")]
        public ?string $description = null,

        #[Assert\Choice(choices: [TaskStatus::PENDING, TaskStatus::IN_PROGRESS, TaskStatus::DONE], message: "Choose a valid status.")]
        #[SerializedName('due_date')]
        public ?\DateTime $dueDate = null,

        #[Assert\DateTime(message: "The due date '{{ value }}' is not a valid datetime.")]
        public TaskStatus|null $status
    ) {

    }

    public function createFromDTO(): Task
    {
        return new Task(
            $this->title,
            $this->description,
            $this->status ? TaskStatus::from($this->status) : TaskStatus::PENDING,
            $this->dueDate
        );
    }
}
