<?php

namespace App\Entity;

use App\Repository\OrganizationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrganizationRepository::class)]
class Organization
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "the name should not be blank")]
    #[Assert\Type("string")]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Assert\Type("integer")]
    #[ORM\Column(nullable: true)]
    private ?int $SIRET = null;

    #[Assert\Type("string")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $postalAddress = null;

    #[Assert\Type("string")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $postalCode = null;

    #[Assert\Type("string")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $website = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $activityArea = null;

    #[Assert\NotBlank(message: "select one of the valid countries")]
    #[Assert\Type(Country::class)]
    #[ORM\ManyToOne(inversedBy: 'organizations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Country $country = null;

    #[Assert\Type("string")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    #[Assert\NotBlank()]
    #[Assert\Type(Organization::class)]
    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'organizations')]
    #[ORM\JoinColumn(nullable: true)]
    private ?self $parent = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private Collection $organizations;

    #[ORM\OneToMany(mappedBy: 'organization', targetEntity: User::class)]
    private Collection $users;

    #[Assert\NotBlank(message: "select one of the valid relations")]
    #[Assert\Type(Relation::class)]
    #[ORM\ManyToOne(inversedBy: 'organizations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Relation $relation = null;

    #[ORM\OneToMany(mappedBy: 'organization', targetEntity: Action::class)]
    private Collection $actions;

    public function __construct()
    {
        $this->organizations = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    public function getSIRET(): ?int
    {
        return $this->SIRET;
    }

    public function setSIRET(?int $SIRET): static
    {
        $this->SIRET = $SIRET;

        return $this;
    }

    public function getPostalAddress(): ?string
    {
        return $this->postalAddress;
    }

    public function setPostalAddress(?string $postalAddress): static
    {
        $this->postalAddress = $postalAddress;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): static
    {
        $this->website = $website;

        return $this;
    }

    public function getActivityArea(): ?string
    {
        return $this->activityArea;
    }

    public function setActivityArea(?string $activityArea): static
    {
        $this->activityArea = $activityArea;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getOrganizations(): Collection
    {
        return $this->organizations;
    }

    public function addOrganization(self $organization): static
    {
        if (!$this->organizations->contains($organization)) {
            $this->organizations->add($organization);
            $organization->setParent($this);
        }

        return $this;
    }

    public function removeOrganization(self $organization): static
    {
        if ($this->organizations->removeElement($organization)) {
            // set the owning side to null (unless already changed)
            if ($organization->getParent() === $this) {
                $organization->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setOrganization($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getOrganization() === $this) {
                $user->setOrganization(null);
            }
        }

        return $this;
    }

    public function getRelation(): ?Relation
    {
        return $this->relation;
    }

    public function setRelation(?Relation $relation): static
    {
        $this->relation = $relation;

        return $this;
    }

    /**
     * @return Collection<int, Action>
     */
    public function getActions(): Collection
    {
        return $this->actions;
    }

    public function addAction(Action $action): static
    {
        if (!$this->actions->contains($action)) {
            $this->actions->add($action);
            $action->setOrganization($this);
        }

        return $this;
    }

    public function removeAction(Action $action): static
    {
        if ($this->actions->removeElement($action)) {
            // set the owning side to null (unless already changed)
            if ($action->getOrganization() === $this) {
                $action->setOrganization(null);
            }
        }

        return $this;
    }
}
