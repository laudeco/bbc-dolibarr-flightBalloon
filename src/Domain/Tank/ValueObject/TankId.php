<?php

namespace Laudeco\Dolibarr\FlightBalloon\Tank\ValueObject;

use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\DomainRowid;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\IdentifiableInterface;

final class TankId implements IdentifiableInterface
{
    use DomainRowid;
}