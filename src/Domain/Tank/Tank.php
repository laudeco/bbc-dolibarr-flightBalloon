<?php

namespace Laudeco\Dolibarr\FlightBalloon\Tank;

use Laudeco\Dolibarr\FlightBalloon\Domain\Common\AggregateRoot;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\AggregateRootInterface;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\IdentifiableInterface;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\Uuid;
use Laudeco\Dolibarr\FlightBalloon\Domain\Manufacturer\ViewModel\ManufacturerId;
use Laudeco\Dolibarr\FlightBalloon\Domain\Shared\ViewModel\BuyDate;
use Laudeco\Dolibarr\FlightBalloon\Domain\Shared\ViewModel\ReasonId;
use Laudeco\Dolibarr\FlightBalloon\Domain\Shared\ViewModel\Weight;
use Laudeco\Dolibarr\FlightBalloon\Tank\ValueObject\Capacity;
use Laudeco\Dolibarr\FlightBalloon\Tank\ValueObject\InspectionDate;
use Laudeco\Dolibarr\FlightBalloon\Tank\ValueObject\Serial;
use Laudeco\Dolibarr\FlightBalloon\Tank\ValueObject\TankId;

final class Tank implements AggregateRootInterface
{
    use AggregateRoot;

    private TankId $id;
    private Uuid $uuid;

    private Serial $serial;
    private BuyDate $buyDate;
    private Capacity $capacity;
    private ManufacturerId $manufacturerId;
    private Weight $weight;
    private InspectionDate $inspectionDate;
    private ReasonId $outReason;

    private function __construct(
        TankId         $id,
        Uuid           $uuid,
        Serial         $serial,
        BuyDate        $buyDate,
        Capacity       $capacity,
        ManufacturerId $manufacturerId,
        Weight         $weight,
        InspectionDate $inspectionDate,
        ReasonId       $outReason
    )
    {
        $this->id = $id;
        $this->uuid = $uuid;
        $this->serial = $serial;
        $this->buyDate = $buyDate;
        $this->capacity = $capacity;
        $this->manufacturerId = $manufacturerId;
        $this->weight = $weight;
        $this->inspectionDate = $inspectionDate;
        $this->outReason = $outReason;
    }


    public function id(): IdentifiableInterface
    {
        return $this->id;
    }

    public static function fromState(array $state): AggregateRootInterface
    {
        // TODO: Implement fromState() method.
    }

    public function state(): array
    {
        // TODO: Implement state() method.
    }
}