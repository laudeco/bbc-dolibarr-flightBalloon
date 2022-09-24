<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Balloon\ValueObject;


use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\DomainRowid;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\IdentifiableInterface;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\Rowid;

final class BalloonId implements IdentifiableInterface
{
    use DomainRowid;
}