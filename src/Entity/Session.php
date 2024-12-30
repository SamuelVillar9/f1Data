<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $sessionName = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $forecast = null;

    #[ORM\ManyToOne(inversedBy: 'sessions')]
    private ?Meeting $meetingId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSessionName(): ?string
    {
        return $this->sessionName;
    }

    public function setSessionName(string $sessionName): static
    {
        $this->sessionName = $sessionName;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getForecast(): ?string
    {
        return $this->forecast;
    }

    public function setForecast(?string $forecast): static
    {
        $this->forecast = $forecast;

        return $this;
    }

    public function getMeetingId(): ?Meeting
    {
        return $this->meetingId;
    }

    public function setMeetingId(?Meeting $meetingId): static
    {
        $this->meetingId = $meetingId;

        return $this;
    }
}
