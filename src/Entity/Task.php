<?php

namespace App\Entity;

use App\Enum\TaskStatus;
use App\Repository\TaskRepository;
use BcMath\Number;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(nullable: false)]
    private int $id;

    #[Assert\NotBlank(message: "The title cannot be blank.")]
    #[ORM\Column(length: 255, nullable: false)]
    private string $title;

    // Assert is string and optional
    #[Assert\Type('string', message: "The description must be a string.")]
    #[Assert\Length(max: 1000, maxMessage: "The description cannot be longer than {{ limit }} characters.")]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[Assert\Choice(choices: [TaskStatus::PENDING, TaskStatus::IN_PROGRESS, TaskStatus::DONE], message: "Choose a valid status.")]
    #[ORM\Column(type: Types::TEXT, enumType: TaskStatus::class)]
    private TaskStatus $status;

    #[Assert\DateTime(message: "The due date '{{ value }}' is not a valid datetime.")]
    #[Assert\GreaterThan("today", message: "The due date must be in the future.")]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTime $dueDate = null;

    public function __construct(
        string $title,
        ?string $description,
        TaskStatus $status,
        ?\DateTime $dueDate
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
        $this->dueDate = $dueDate;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(Number $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?TaskStatus
    {
        return $this->status;
    }

    public function setStatus(TaskStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getDueDate(): ?\DateTime
    {
        return $this->dueDate;
    }

    public function setDueDate(?\DateTime $dueDate): static
    {
        $this->dueDate = $dueDate;

        return $this;
    }
}
