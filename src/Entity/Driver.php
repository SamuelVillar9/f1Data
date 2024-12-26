<?php

namespace App\Entity;

use App\Repository\DriverRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DriverRepository::class)]
class Driver
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $fullDriverName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $urlDriverPhoto = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $country = null;

    #[ORM\Column(nullable: true)]
    private ?int $racingNumber = null;

    #[ORM\ManyToOne(inversedBy: 'drivers')]
    private ?Team $teamId = null;

    #[ORM\ManyToOne(inversedBy: 'drivers')]
    private ?Season $season = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullDriverName(): ?string
    {
        return $this->fullDriverName;
    }

    public function setFullDriverName(string $fullDriverName): static
    {
        $this->fullDriverName = $fullDriverName;

        return $this;
    }

    public function getUrlDriverPhoto(): ?string
    {
        return $this->urlDriverPhoto;
    }

    public function setUrlDriverPhoto(?string $urlDriverPhoto): static
    {
        $this->urlDriverPhoto = $urlDriverPhoto;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getRacingNumber(): ?int
    {
        return $this->racingNumber;
    }

    public function setRacingNumber(?int $racingNumber): static
    {
        $this->racingNumber = $racingNumber;

        return $this;
    }

    public function getTeamId(): ?Team
    {
        return $this->teamId;
    }

    public function setTeamId(?Team $teamId): static
    {
        $this->teamId = $teamId;

        return $this;
    }

    public function getSeason(): ?Season
    {
        return $this->season;
    }

    public function setSeason(?Season $season): static
    {
        $this->season = $season;

        return $this;
    }
}
