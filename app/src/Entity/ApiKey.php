<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\ApiKeyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: ApiKeyRepository::class)]
class ApiKey implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $value = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $service = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $creator = null;

    #[ORM\Column]
    private ?int $creatorTnn = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = trim($value);

        return $this;
    }

    public function getService(): ?string
    {
        return $this->service;
    }

    public function setService(string $service): static
    {
        $this->service = trim($service);

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = trim($description);

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->getService();
    }

    public function getRoles(): array
    {
        return ['ROLE_SERVICE'];
    }

    public function eraseCredentials(): void
    {

    }

    public function getCreator(): ?string
    {
        return $this->creator;
    }

    public function setCreator(string $creator): static
    {
        $this->creator = trim($creator);

        return $this;
    }

    public function getCreatorTnn(): ?int
    {
        return $this->creatorTnn;
    }

    public function setCreatorTnn(int $creatorTnn): static
    {
        $this->creatorTnn = $creatorTnn;

        return $this;
    }
}
