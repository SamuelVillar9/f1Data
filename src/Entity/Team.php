<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $fullNameTeam = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $base = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $urlTeamLogo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $urlTeamCar = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $teamChief = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $technicalChief = null;

    #[ORM\ManyToOne(inversedBy: 'teams')]
    private ?Season $seasonId = null;

    /**
     * @var Collection<int, Driver>
     */
    #[ORM\OneToMany(targetEntity: Driver::class, mappedBy: 'teamId')]
    private Collection $drivers;

    public function __construct()
    {
        $this->drivers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullNameTeam(): ?string
    {
        return $this->fullNameTeam;
    }

    public function setFullNameTeam(string $fullNameTeam): static
    {
        $this->fullNameTeam = $fullNameTeam;

        return $this;
    }

    public function getBase(): ?string
    {
        return $this->base;
    }

    public function setBase(?string $base): static
    {
        $this->base = $base;

        return $this;
    }

    public function getUrlTeamLogo(): ?string
    {
        return $this->urlTeamLogo;
    }

    public function setUrlTeamLogo(?string $urlTeamLogo): static
    {
        $this->urlTeamLogo = $urlTeamLogo;

        return $this;
    }

    public function getUrlTeamCar(): ?string
    {
        return $this->urlTeamCar;
    }

    public function setUrlTeamCar(?string $urlTeamCar): static
    {
        $this->urlTeamCar = $urlTeamCar;

        return $this;
    }

    public function getTeamChief(): ?string
    {
        return $this->teamChief;
    }

    public function setTeamChief(?string $teamChief): static
    {
        $this->teamChief = $teamChief;

        return $this;
    }

    public function getTechnicalChief(): ?string
    {
        return $this->technicalChief;
    }

    public function setTechnicalChief(?string $technicalChief): static
    {
        $this->technicalChief = $technicalChief;

        return $this;
    }

    public function getSeasonId(): ?Season
    {
        return $this->seasonId;
    }

    public function setSeasonId(?Season $seasonId): static
    {
        $this->seasonId = $seasonId;

        return $this;
    }

    /**
     * @return Collection<int, Driver>
     */
    public function getDrivers(): Collection
    {
        return $this->drivers;
    }

    public function addDriver(Driver $driver): static
    {
        if (!$this->drivers->contains($driver)) {
            $this->drivers->add($driver);
            $driver->setTeamId($this);
        }

        return $this;
    }

    public function removeDriver(Driver $driver): static
    {
        if ($this->drivers->removeElement($driver)) {
            // set the owning side to null (unless already changed)
            if ($driver->getTeamId() === $this) {
                $driver->setTeamId(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->fullNameTeam;
    }
}
