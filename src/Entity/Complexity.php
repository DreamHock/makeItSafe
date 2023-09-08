<?php

namespace App\Entity;

use App\Repository\ComplexityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComplexityRepository::class)]
class Complexity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'complexity', targetEntity: Action::class)]
    private Collection $actions;

    public function __construct()
    {
        $this->actions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Action>
     */
    public function getActions(): Collection
    {
        return $this->actions;
    }

    public function addAction(Action $Action): static
    {
        if (!$this->actions->contains($Action)) {
            $this->actions->add($Action);
            $Action->setComplexity($this);
        }

        return $this;
    }

    public function removeAction(Action $Action): static
    {
        if ($this->actions->removeElement($Action)) {
            // set the owning side to null (unless already changed)
            if ($Action->getComplexity() === $this) {
                $Action->setComplexity(null);
            }
        }

        return $this;
    }
}
