<?php

namespace App\Entity;

use AllowDynamicProperties;
use App\Repository\TeamsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamsRepository::class)]
class Teams
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(type: 'datetime')]
    protected \DateTimeInterface $date;

    private ?TournamentsTeams $tournaments_teams = null;

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

    public function setDate(\DateTimeInterface $date = null): void
    {
        if(!$date)
            $date = new \DateTime('now', new \DateTimeZone('Europe/Moscow'));

        $this->date = $date;
    }
    public function getTournamentsTeams(): ?TournamentsTeams
    {
        return $this->tournaments_teams;
    }

    public function setTournamentsTeams(?TournamentsTeams $tournaments_teams): static
    {
        $this->tournaments_teams = $tournaments_teams;

        return $this;
    }

    public function teamsToArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName() ?? ''
        ];

    }
}
