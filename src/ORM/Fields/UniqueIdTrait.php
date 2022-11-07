<?php


namespace App\ORM\Fields;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

trait UniqueIdTrait
{
    #[ORM\Column(type: 'uuid')]
    protected ?Uuid $uniqueId = null;


    /**
     * @return Uuid|null
     */
    public function getUniqueId(): ?Uuid
    {
        return $this->uniqueId;
    }

    /**
     * @param string $prefix
     */
    public function setUniqueId(?Uuid $uuid = null): void
    {
        $this->uniqueId =  $uuid instanceof Uuid ? $uuid :  Uuid::v1();

    }
}
