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
use App\Controller\CompanyCreateAction;
use App\Repository\CompanyRepository;
use App\State\CompanyCreateProcessor;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(
            uriTemplate: '/companies/create',
            controller: CompanyCreateAction::class,
            validate: false,
            name: 'createCompany'
        ),
        new Delete(),
        new Get(),
        new Patch()
    ],
    normalizationContext: ['groups' => ['company:read']],
    denormalizationContext: ['groups' => ['company:write']],
)]
#[ApiFilter(
    SearchFilter::class,
    properties: [
        'id' => 'exact',
        'email' => 'partial',
        'name' => 'partial',
        'password' => 'partial',
    ]
)]
#[ApiFilter(OrderFilter::class, properties: ['id'])]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Ism bo'sh bo'lmasligi kerak.")]
    #[Groups(['company:read', 'company:write', 'customer:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Email bo'sh bo'lmasligi kerak.")]
    #[Groups(['company:read', 'company:write'])]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Parol bo'sh bo'lmasligi kerak.")]
    #[Groups(['company:read', 'company:write'])]
    private ?string $password = null;

    #[ORM\Column]
    #[Groups(['company:read'])]
    private ?\DateTimeImmutable $lastActivity = null;

    #[ORM\Column]
    #[Groups(['company:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['company:read'])]
    private ?User $createdBy = null;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

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

    public function getLastActivity(): ?\DateTimeImmutable
    {
        return $this->lastActivity;
    }

    public function setLastActivity(\DateTimeImmutable $lastActivity): static
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

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }
}
