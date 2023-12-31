<?php

namespace App\Entity;

use App\Repository\ActionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ActionRepository::class)]
class Action
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "the title should not be blank")]
    #[Assert\Type("string", message: "the title should be of Type string")]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Assert\Type("string", message: "the description should be of Type string")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[Assert\DateTime(message: "chose a valid date")]
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $startAt = null;

    #[Assert\DateTime(message: "chose a valid date")]
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $dueAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reference = null;

    #[Assert\Type(Complexity::class, message: "chose a valid complexity")]
    #[ORM\ManyToOne(inversedBy: 'actions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Complexity $complexity = null;

    #[Assert\Type(Priority::class, message: "chose a valid priority")]
    #[ORM\ManyToOne(inversedBy: 'actions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Priority $priority = null;

    #[Assert\NotBlank(message: "chose one of the valid organization")]
    #[Assert\Type(Organization::class, message: "chose one of the valid organization")]
    #[ORM\ManyToOne(inversedBy: 'actions')]
    #[ORM\JoinColumn(nullable: false)]
    #[MaxDepth(1)]
    private ?Organization $organization = null;

    #[ORM\ManyToOne(inversedBy: 'actions')]
    #[ORM\JoinColumn(nullable: false)]
    #[MaxDepth(1)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'actions')]
    private ?Status $status = null;

    #[ORM\Column]
    private ?bool $isReccurent = null;

    #[ORM\Column(nullable: true, name: "`interval`")]
    private ?int $interval = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $nextUpdatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(string $id): static
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

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(?\DateTimeImmutable $startAt): static
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getDueAt(): ?\DateTimeImmutable
    {
        return $this->dueAt;
    }

    public function setDueAt(?\DateTimeImmutable $dueAt): static
    {
        $this->dueAt = $dueAt;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getComplexity(): ?Complexity
    {
        return $this->complexity;
    }

    public function setComplexity(?Complexity $complexity): static
    {
        $this->complexity = $complexity;

        return $this;
    }

    public function getPriority(): ?Priority
    {
        return $this->priority;
    }

    public function setPriority(?Priority $priority): static
    {
        $this->priority = $priority;

        return $this;
    }

    public function getOrganization(): ?Organization
    {
        return $this->organization;
    }

    public function setOrganization(?Organization $organization): static
    {
        $this->organization = $organization;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function isIsReccurent(): ?bool
    {
        return $this->isReccurent;
    }

    public function setIsReccurent(?bool $isReccurent): static
    {
        $this->isReccurent = $isReccurent;

        return $this;
    }

    public function getInterval(): ?int
    {
        return $this->interval;
    }

    public function setInterval(?int $interval): static
    {
        $this->interval = $interval;

        return $this;
    }

    public function getNextUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->nextUpdatedAt;
    }

    public function setNextUpdatedAt(\DateTimeImmutable $nextUpdatedAt): static
    {
        $this->nextUpdatedAt = $nextUpdatedAt;

        return $this;
    }
}
