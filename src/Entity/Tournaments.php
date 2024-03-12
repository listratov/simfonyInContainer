<?php

namespace App\Entity;

use App\Repository\TournamentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

#[ORM\Entity(repositoryClass: TournamentsRepository::class)]
#[UniqueEntity('slug')]
class Tournaments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(name: 'name', type: 'string', length: 255)]
    #[Assert\Length(min: 3, max: 255)]
    #[Assert\NotBlank]
    protected string $name;

    #[ORM\Column(name: 'slug', type: 'string', length: 255, unique: true)]
    #[Assert\NotBlank]
    protected string $slug;

    #[ORM\Column(type: 'datetime')]
    protected ?\DateTimeInterface $date = null;

    #[ORM\OneToMany(mappedBy: 'tournaments', targetEntity: TournamentsTeams::class)]
    protected $tournaments_teams = null;


    public function __construct()
    {
        $this->tournaments_teams = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date = null): void
    {
        if (!$date)
            $date = new \DateTime('now', new \DateTimeZone('Europe/Moscow'));

        $this->date = $date;
    }

    public function getTournamentsTeams(): ArrayCollection
    {
        return $this->tournaments_teams;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

//    public static function loadValidatorMetadata(ClassMetadata $metadata): void
//    {
//        $metadata->addPropertyConstraint('name', new Assert\NotBlank());
//    }

}
