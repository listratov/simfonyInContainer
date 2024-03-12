<?php

namespace App\Entity;

use App\Repository\TeamsCardRepository;
use App\Repository\TeamsRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TeamsCardRepository::class)]
#[ORM\Table(name: 'teams')]
class TeamsCard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'name', type: 'string', length: 255)]
    #[Assert\Length(min: 3, max: 255)]
    #[Assert\NotBlank]
    private string $name;

    #[ORM\Column(name: 'description', type: 'string', length: 255)]
    #[Assert\Length(min: 3, max: 255)]
    private ?string $description = null;


    #[ORM\Column(type: 'datetime')]
    protected \DateTimeInterface $date;

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

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function teamsToArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName() ?? ''
        ];

    }
}
