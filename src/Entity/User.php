<?php

namespace App\Entity;

// use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity('email', message: "this email already taken", errorPath: "emailTaken")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "email should not be blank")]
    #[Assert\Email(message: "email should be a valid email")]
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column(nullable: true)]
    private ?string $password = null;

    #[Assert\NotBlank(message: "first name should not be blank")]
    #[Assert\Type('string', message: "the first name should be a string")]
    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[Assert\NotBlank(message: "last name should not be blank")]
    #[Assert\Type('string', message: "the last name should be a string")]
    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[Assert\Type('string')]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    #[Assert\Type('string')]
    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[Assert\Type('string')]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $function = null;

    #[Assert\DateTime(message: "the end demo at should be a valid date")]
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $endDemoAt = null;

    #[Assert\DateTime(message: "the end validation at should be a valid date")]
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $endValidationAt = null;

    #[Assert\Type('boolean', message: "this has to be either true or false")]
    #[ORM\Column(nullable: true)]
    private ?bool $hasNotifications = null;

    #[Assert\NotBlank()]
    #[Assert\Type('boolean', message: "this has to be either true or false")]
    #[ORM\Column]
    private ?bool $hasInvitation = null;

    #[Assert\Type(Language::class)]
    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Language $language = null;

    #[Assert\email()]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contactEmail = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Organization $organization = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Action::class)]
    private Collection $actions;

    public function __construct()
    {
        $this->actions = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUsername(): string
    {
        return $this->getUserIdentifier();
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getFunction(): ?string
    {
        return $this->function;
    }

    public function setFunction(?string $function): static
    {
        $this->function = $function;

        return $this;
    }

    public function getEndValidationAt(): ?\DateTimeImmutable
    {
        return $this->endValidationAt;
    }

    public function setEndValidationAt(?\DateTimeImmutable $endValidationAt): static
    {
        $this->endValidationAt = $endValidationAt;

        return $this;
    }

    public function getEndDemoAt(): ?\DateTimeImmutable
    {
        return $this->endDemoAt;
    }

    public function setEndDemoAt(?\DateTimeImmutable $endDemoAt): static
    {
        $this->endDemoAt = $endDemoAt;

        return $this;
    }

    public function isHasNotifications(): ?bool
    {
        return $this->hasNotifications;
    }

    public function setHasNotifications(?bool $hasNotifications): static
    {
        $this->hasNotifications = $hasNotifications;

        return $this;
    }

    public function isHasInvitation(): ?bool
    {
        return $this->hasInvitation;
    }

    public function setHasInvitation(bool $hasInvitation): static
    {
        $this->hasInvitation = $hasInvitation;

        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): static
    {
        $this->language = $language;

        return $this;
    }

    public function getContactEmail(): ?string
    {
        return $this->contactEmail;
    }

    public function setContactEmail(?string $contactEmail): static
    {
        $this->contactEmail = $contactEmail;

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
            $action->setUser($this);
        }

        return $this;
    }

    public function removeAction(Action $action): static
    {
        if ($this->actions->removeElement($action)) {
            // set the owning side to null (unless already changed)
            if ($action->getUser() === $this) {
                $action->setUser(null);
            }
        }

        return $this;
    }
}
