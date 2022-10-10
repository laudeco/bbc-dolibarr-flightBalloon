<?php

namespace Laudeco\Dolibarr\FlightBalloon\Tank;

use Laudeco\Dolibarr\FlightBalloon\Domain\Common\AggregateRoot;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\AggregateRootInterface;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\IdentifiableInterface;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\Rowid;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\Uuid;
use Laudeco\Dolibarr\FlightBalloon\Domain\Manufacturer\ViewModel\ManufacturerId;
use Laudeco\Dolibarr\FlightBalloon\Domain\Shared\ViewModel\BuyDate;
use Laudeco\Dolibarr\FlightBalloon\Domain\Shared\ViewModel\Create;
use Laudeco\Dolibarr\FlightBalloon\Domain\Shared\ViewModel\ReasonId;
use Laudeco\Dolibarr\FlightBalloon\Domain\Shared\ViewModel\Weight;
use Laudeco\Dolibarr\FlightBalloon\Tank\Event\TankCreated;
use Laudeco\Dolibarr\FlightBalloon\Tank\Event\TankDeprecated;
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
    private Create $create;

    private function __construct(
        TankId         $id,
        Uuid           $uuid,
        Serial         $serial,
        BuyDate        $buyDate,
        Capacity       $capacity,
        ManufacturerId $manufacturerId,
        Weight         $weight,
        InspectionDate $inspectionDate,
        ReasonId       $outReason,
        Create         $create
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
        $this->create = $create;
    }


    public function id(): IdentifiableInterface
    {
        return $this->id;
    }

    public static function create(
        TankId         $id,
        Uuid           $uuid,
        Serial         $serial,
        BuyDate        $buyDate,
        Capacity       $capacity,
        ManufacturerId $manufacturerId,
        Weight         $weight,
        InspectionDate $inspectionDate,
        Rowid          $author
    ): self
    {
        $tank = new self(
            $id,
            $uuid,
            $serial,
            $buyDate,
            $capacity,
            $manufacturerId,
            $weight,
            $inspectionDate,
            ReasonId::zero(),
            Create::now($author)
        );

        $tank->recordThat(TankCreated::create($id));

        return $tank;
    }

    public function deprecate(ReasonId $reason, Rowid $author): self
    {
        $this->outReason = $reason;
        $this->recordThat(TankDeprecated::create($this->id, $reason, $author));
    }

    public static function fromState(array $state): AggregateRootInterface
    {
        return new self(
            TankId::fromInt($state['id']),
            Uuid::fromString($state['uuid']),
            Serial::fromSerial($state['serial']),
            BuyDate::fromString($state['buy_date']),
            Capacity::fromLiter($state['capacity']),
            ManufacturerId::fromString($state['manufacturer_id']),
            Weight::fromInt($state['weight']),
            InspectionDate::fromString($state['previous_inspection_date'], $state['next_inspection_date']),
            ReasonId::fromInt($state['out_reason']),
            Create::create(
                Rowid::fromInt($state['creator']),
                $state['created_at']
            )
        );
    }

    public function state(): array
    {
        return [
            'id' => $this->id->asString(),
            'uuid' => $this->uuid->asString(),
            'buy_date' => $this->buyDate->asString(),
            'weight' => $this->weight->asInt(),
            'serial' => $this->serial->asString(),
            'capacity' => $this->capacity->asLiter(),
            'out_reason' => $this->outReason->asInt(),
            'previous_inspection_date' => $this->inspectionDate->state()['previous'],
            'next_inspection_date' => $this->inspectionDate->state()['next'],
            'manufacturer_id' => $this->manufacturerId->asString(),
            'creator' => $this->create->state()['creator'],
            'created_at' => $this->create->state()['at'],
        ];
    }
}