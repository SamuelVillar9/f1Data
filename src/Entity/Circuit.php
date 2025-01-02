<?php

namespace App\Entity;

use App\Repository\CircuitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CircuitRepository::class)]
class Circuit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $circuitName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $country = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lengthKm = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $urlCircuitPhoto = null;

    /**
     * @var Collection<int, Meeting>
     */
    #[ORM\OneToMany(targetEntity: Meeting::class, mappedBy: 'circuitId')]
    private Collection $meetings;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $countryCode = null;

    public function __construct()
    {
        $this->meetings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCircuitName(): ?string
    {
        return $this->circuitName;
    }

    public function setCircuitName(string $circuitName): static
    {
        $this->circuitName = $circuitName;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): static
    {
        $this->location = $location;

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

    public function getLengthKm(): ?string
    {
        return $this->lengthKm;
    }

    public function setLengthKm(?string $lengthKm): static
    {
        $this->lengthKm = $lengthKm;

        return $this;
    }

    public function getUrlCircuitPhoto(): ?string
    {
        return $this->urlCircuitPhoto;
    }

    public function setUrlCircuitPhoto(?string $urlCircuitPhoto): static
    {
        $this->urlCircuitPhoto = $urlCircuitPhoto;

        return $this;
    }

    /**
     * @return Collection<int, Meeting>
     */
    public function getMeetings(): Collection
    {
        return $this->meetings;
    }

    public function addMeeting(Meeting $meeting): static
    {
        if (!$this->meetings->contains($meeting)) {
            $this->meetings->add($meeting);
            $meeting->setCircuitId($this);
        }

        return $this;
    }

    public function removeMeeting(Meeting $meeting): static
    {
        if ($this->meetings->removeElement($meeting)) {
            // set the owning side to null (unless already changed)
            if ($meeting->getCircuitId() === $this) {
                $meeting->setCircuitId(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->circuitName;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(?string $countryCode): static
    {
        $this->countryCode = $countryCode;

        return $this;
    }
}
