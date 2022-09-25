<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Manufacturer\Event;


use Laudeco\Dolibarr\FlightBalloon\Domain\Common\Event\AbstractEvent;
use Laudeco\Dolibarr\FlightBalloon\Domain\Manufacturer\ViewModel\ManufacturerId;

abstract class AbstractManufacturerEvent extends AbstractEvent
{
    private ManufacturerId $manufacturerId;

    public function __construct(ManufacturerId $manufacturerId, string $id)
    {
        parent::__construct($id);
        $this->manufacturerId = $manufacturerId;
    }

    public function balloonId(): ManufacturerId
    {
        return $this->manufacturerId;
    }

    public function state(): array
    {
        return array_merge(parent::state(), [
            'manufacturer_id' => $this->manufacturerId->asString(),
        ]);
    }
}