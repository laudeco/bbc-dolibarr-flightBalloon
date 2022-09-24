<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Manufacturer\ViewModel;


use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\DomainRowid;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\IdentifiableInterface;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\Rowid;

final class ManufacturerId implements IdentifiableInterface
{
    use DomainRowid;
}