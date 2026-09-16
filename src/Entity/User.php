<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\UserCreateAction;
use App\Controller\GetMeAction;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity('email', message: "Bu {{value}} email manzil tizimda allaqachon ro'yxatdan o'tgan.")]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(
            controller: GetMeAction::class,
            read: false,
            name: 'me',
            normalizationContext: ['groups' => ['user:read']]
        ),
        new Post(
            uriTemplate: '/users/create',
            controller: UserCreateAction::class,
            validate: false,
            name: 'createUser'
        ),
        new Post(
            uriTemplate: '/users/auth',
            name: 'auth'
        ),
        new Delete(),
        new Get(),
        new Patch()
    ],
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']],
)]
#[ApiFilter(
    SearchFilter::class,
    properties: [
        'id' => 'exact',
        'email' => 'partial',
        'fullName' => 'partial',
        'password' => 'partial',
    ]
)]
#[ApiFilter(OrderFilter::class, properties: ['id'])]
class User implements PasswordAuthenticatedUserInterface, UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Ism bo'sh bo'lmasligi kerak.")]
    #[Groups(['user:read', 'user:write'])]
    private ?string $fullName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Email bo'sh bo'lmasligi kerak.")]
    #[Assert\Email(message: "Email formati noto'g'ri.")]
    #[Groups(['user:read', 'user:write'])]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups(['user:read'])]
    private array $roles = ["ROLE_USER"];

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Parol bo'sh bo'lmasligi kerak.")]
    #[Groups(['user:read', 'user:write'])]
    private ?string $password = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['user:read'])]
    private ?\DateTime $lastActivity = null;

    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: "Rasm bo'sh bo'lmasligi kerak.")]
    #[Groups(['user:read', 'user:write'])]
    private ?MediaObject $photo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): static
    {
        $this->fullName = $fullName;

        return $this;
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

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getLastActivity(): ?\DateTime
    {
        return $this->lastActivity;
    }

    public function setLastActivity(?\DateTime $lastActivity): static
    {
        $this->lastActivity = $lastActivity;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPhoto(): ?MediaObject
    {
        return $this->photo;
    }

    public function setPhoto(MediaObject $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->getEmail();
    }
}
