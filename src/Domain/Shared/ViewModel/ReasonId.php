<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Shared\ViewModel;


use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\IdentifiableInterface;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\Rowid;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\ZeroDomainRowid;

final class ReasonId implements IdentifiableInterface
{
    use ZeroDomainRowid;
}