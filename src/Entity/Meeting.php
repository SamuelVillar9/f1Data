<?php

namespace App\Entity;

use App\Repository\MeetingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeetingRepository::class)]
class Meeting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $dates = null;

    #[ORM\Column(length: 255)]
    private ?string $meetingName = null;

    #[ORM\Column]
    private ?int $raceLaps = null;

    #[ORM\ManyToOne(inversedBy: 'meetings')]
    private ?Schedule $scheduleId = null;

    #[ORM\ManyToOne(inversedBy: 'meetings')]
    private ?Circuit $circuitId = null;

    /**
     * @var Collection<int, Session>
     */
    #[ORM\OneToMany(targetEntity: Session::class, mappedBy: 'meetingId')]
    private Collection $sessions;

    #[ORM\Column]
    private ?int $roundNumber = null;

    public function __construct()
    {
        $this->sessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDates(): ?string
    {
        return $this->dates;
    }

    public function setDates(string $dates): static
    {
        $this->dates = $dates;

        return $this;
    }

    public function getMeetingName(): ?string
    {
        return $this->meetingName;
    }

    public function setMeetingName(string $meetingName): static
    {
        $this->meetingName = $meetingName;

        return $this;
    }

    public function getRaceLaps(): ?int
    {
        return $this->raceLaps;
    }

    public function setRaceLaps(int $raceLaps): static
    {
        $this->raceLaps = $raceLaps;

        return $this;
    }

    public function getScheduleId(): ?Schedule
    {
        return $this->scheduleId;
    }

    public function setScheduleId(?Schedule $scheduleId): static
    {
        $this->scheduleId = $scheduleId;

        return $this;
    }

    public function getCircuitId(): ?Circuit
    {
        return $this->circuitId;
    }

    public function setCircuitId(?Circuit $circuitId): static
    {
        $this->circuitId = $circuitId;

        return $this;
    }

    /**
     * @return Collection<int, Session>
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): static
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions->add($session);
            $session->setMeetingId($this);
        }

        return $this;
    }

    public function removeSession(Session $session): static
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getMeetingId() === $this) {
                $session->setMeetingId(null);
            }
        }

        return $this;
    }

    public function getRoundNumber(): ?int
    {
        return $this->roundNumber;
    }

    public function setRoundNumber(int $roundNumber): static
    {
        $this->roundNumber = $roundNumber;

        return $this;
    }
}
