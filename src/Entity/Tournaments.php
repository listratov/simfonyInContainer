<?php

namespace App\Entity;

use App\Repository\TournamentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TournamentsRepository::class)]
class Tournaments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(type: 'datetime')]
    protected ?\DateTimeInterface $date = null;

    #[ORM\OneToMany(mappedBy: 'tournaments', targetEntity: TournamentsTeams::class)]
    private $tournaments_teams = null;


    public function __construct()
    {
        $this->tournaments_teams = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date = null)
    {
        if(!$date)
            $date = new \DateTime('now', new \DateTimeZone('Europe/Moscow'));

        $this->date = $date;
    }

    public function getTournamentsTeams(): ArrayCollection
    {
        return $this->tournaments_teams;
    }

}
