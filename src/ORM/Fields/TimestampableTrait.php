<?php


namespace App\ORM\Fields;

use App\ORM\Fields\Timestampable\TimestampableMethods;
use App\ORM\Fields\Timestampable\TimestampableProperties;
use Doctrine\ORM\Mapping as ORM;


/**
 * Timestampable trait.
 *
 * Should be used inside entity, that needs to be timestamped.
 */
#[ORM\HasLifecycleCallbacks]
trait TimestampableTrait
{
    use TimestampableProperties,
        TimestampableMethods;
}


