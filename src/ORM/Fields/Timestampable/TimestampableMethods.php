<?php


namespace App\ORM\Fields\Timestampable;

use DateTime;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;

/**
 * Timestampable trait.
 *
 * Should be used inside entity, that needs to be timestamped.
 */

#[ORM\HasLifecycleCallbacks]
trait TimestampableMethods
{
    /**
     * Returns createdAt value.
     *
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        if (!$this->createdAt) {
            $this->updateTimestamps();
        }
        return $this->createdAt;
    }

    /**
     * Returns updatedAt value.
     *
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $createdAt
     * @return $this
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @param DateTime $updatedAt
     * @return $this
     */
    public function setUpdatedAt(DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Updates createdAt and updatedAt timestamps.
     */

    #[ORM\PreUpdate]
    #[ORM\PrePersist]
    public function updateTimestamps(): void
    {
        // Create a datetime with microseconds
        $dateTime = new \DateTime('now', new \DateTimeZone('UTC'));
        $dateTime->setTimezone(new DateTimeZone(date_default_timezone_get()));

        if (null === $this->createdAt) {
            $this->createdAt = $dateTime;
        }

        $this->updatedAt = $dateTime;
    }
}
