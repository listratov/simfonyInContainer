<?php

namespace App\Entity;

use App\Repository\TournamentsRepository;
use App\Repository\TournamentsTeamsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: TournamentsTeamsRepository::class)]
class TournamentsTeams
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Tournaments::class)]
    #[JoinColumn(name: "tournaments_id", referencedColumnName: "id")]
    private $tournaments;

    #[ORM\OneToOne(targetEntity: Teams::class)]
    #[JoinColumn(name: "teams_id", referencedColumnName: "id")]
    private $teams_id;

    #[ORM\OneToOne(targetEntity: Teams::class)]
    #[JoinColumn(name: "teams_id2", referencedColumnName: "id")]
    private $teams_id2;

    #[Column(type: 'datetime')]
    private \DateTime $date;


    public function __construct()
    {
        $this->teams_id = new ArrayCollection();
        $this->teams_id2 = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTeamsId2()
    {
        return $this->teams_id2;
    }

    public function setTeamsId2($teams_id2)
    {
        $this->teams_id2 = $teams_id2;
    }

    /**
     * @return Collection
     */
    public function getTeams(): Collection
    {
        return $this->teams_id;
    }

    public function getTournaments()
    {
        return $this->tournaments;
    }

    public function setTournamentsId($tournaments_id)
    {
        $this->tournaments = $tournaments_id;
    }

    public function getTeamsId()
    {
        return $this->teams_id;
    }

    public function setTeamsId($teams_id)
    {
        $this->teams_id = $teams_id;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    public function getTournamentsToArray(): array
    {
        return [
            'id' => $this->getId(),
            'tournaments_id' => $this->getTournaments()->getId()
        ];
    }
}
