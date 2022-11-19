<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\ORM\Fields\MetadataTrait;
use App\ORM\Fields\TimestampableTrait;
use App\ORM\Fields\UniqueIdTrait;
use App\Repository\BookingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
#[ApiResource]
#[UniqueEntity(
    fields: ['bookingTime', 'duration'],
    message: 'This date time is already in use. Select other or use the calendar view to avoid concurrency.',
    repositoryMethod: 'findConcurrency',
    errorPath: 'bookingTime'
)]
#[ORM\HasLifecycleCallbacks]
class Booking
{
    public const dateFormat = 'Y m d H:i a';
    public function __toString(): string
    {
        return $this->bookingTime->format(self::dateFormat) . ' - '.$this->duration . 'm';
    }

    use MetadataTrait;
    use TimestampableTrait;
    use UniqueIdTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $bookingTime = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $endTime = null;

    #[ORM\Column]
    private ?int $duration = null;

    #[ORM\Column(length: 255)]
    private ?string $visibility = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    private array $labSet = [];

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    public function __construct()
    {
        $this->updateTimestamps();
        $this->setUniqueid();

    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getBookingTime(): ?\DateTimeInterface
    {
        return $this->bookingTime;
    }

    public function setBookingTime(\DateTimeInterface $bookingTime): self
    {
        $this->bookingTime = $bookingTime;

        return $this;
    }


    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(\DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getVisibility(): ?string
    {
        return $this->visibility;
    }

    public function setVisibility(string $visibility): self
    {
        $this->visibility = $visibility;

        return $this;
    }

    public function getLabSet(): array
    {
        return $this->labSet;
    }

    public function setLabSet(array $labSet): self
    {
        $this->labSet = $labSet;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }


    /**
     * Updates the endTime using duration field
     * @throws \Exception
     */

    #[ORM\PreUpdate]
    #[ORM\PrePersist]
    public function updateEndTime(): void
    {
        $this->endTime = clone $this->bookingTime;
        $this->endTime = $this->endTime->add(new \DateInterval('PT' . $this->duration . 'M'));
    }

}
