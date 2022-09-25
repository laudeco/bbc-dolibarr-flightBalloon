<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Manufacturer\Event;


use Laudeco\Dolibarr\FlightBalloon\Domain\Common\Event\AbstractEvent;
use Laudeco\Dolibarr\FlightBalloon\Domain\Manufacturer\ViewModel\ManufacturerId;

final class ManufacturerCreated extends AbstractManufacturerEvent
{

    private function __construct(ManufacturerId $manufacturerId)
    {
        parent::__construct($manufacturerId, 'manufacturer.created');
    }

    public static function create(ManufacturerId $manufacturerId): self
    {
        return new self($manufacturerId);
    }

}