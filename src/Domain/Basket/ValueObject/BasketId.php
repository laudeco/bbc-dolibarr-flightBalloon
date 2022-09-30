<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Basket\ValueObject;


use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\DomainRowid;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\IdentifiableInterface;

final class BasketId implements IdentifiableInterface
{
    use DomainRowid;

}