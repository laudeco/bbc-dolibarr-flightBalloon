<?php

namespace Laudeco\Dolibarr\FlightBalloon\Domain\Balloon;

use Laudeco\Dolibarr\FlightBalloon\Domain\Balloon\Event\BalloonCreated;
use Laudeco\Dolibarr\FlightBalloon\Domain\Balloon\Event\BalloonDeprecated;
use Laudeco\Dolibarr\FlightBalloon\Domain\Balloon\Event\BalloonFlew;
use Laudeco\Dolibarr\FlightBalloon\Domain\Balloon\Event\BalloonFlightTimeCorrected;
use Laudeco\Dolibarr\FlightBalloon\Domain\Balloon\ValueObject\BalloonId;
use Laudeco\Dolibarr\FlightBalloon\Domain\Balloon\ValueObject\Immatriculation;
use Laudeco\Dolibarr\FlightBalloon\Domain\Balloon\ValueObject\MarraineName;
use Laudeco\Dolibarr\FlightBalloon\Domain\Balloon\ValueObject\Model;
use Laudeco\Dolibarr\FlightBalloon\Domain\Balloon\ValueObject\Sponsored;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\AggregateRoot;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\AggregateRootInterface;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\IdentifiableInterface;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\Rowid;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\Uuid;
use Laudeco\Dolibarr\FlightBalloon\Domain\Manufacturer\ViewModel\ManufacturerId;
use Laudeco\Dolibarr\FlightBalloon\Domain\Shared\ViewModel\BuyDate;
use Laudeco\Dolibarr\FlightBalloon\Domain\Shared\ViewModel\Create;
use Laudeco\Dolibarr\FlightBalloon\Domain\Shared\ViewModel\FlightTime;
use Laudeco\Dolibarr\FlightBalloon\Domain\Shared\ViewModel\ReasonId;
use Laudeco\Dolibarr\FlightBalloon\Domain\Shared\ViewModel\Weight;

final class Balloon implements AggregateRootInterface
{
    use AggregateRoot;

    private BalloonId $id;
    private Uuid $uuid;

    private Immatriculation $immat;
    private Model $model;
    private BuyDate $buyDate;
    private FlightTime $flightTime;
    private Weight $weight;
    private MarraineName $marraine;
    private Sponsored $sponsored;
    private ReasonId $outReason;
    private ManufacturerId $manufacturerId;
    private Create $create;

    private function __construct(
        BalloonId       $id,
        Uuid            $uuid,
        Immatriculation $immat,
        Model           $model,
        BuyDate         $buyDate,
        FlightTime      $flightTime,
        Weight          $weight,
        MarraineName    $marraine,
        Sponsored       $sponsored,
        ReasonId        $outReason,
        ManufacturerId  $manufacturerId,
        Create          $create
    )
    {
        $this->id = $id;
        $this->uuid = $uuid;
        $this->immat = $immat;
        $this->model = $model;
        $this->buyDate = $buyDate;
        $this->flightTime = $flightTime;
        $this->weight = $weight;
        $this->marraine = $marraine;
        $this->sponsored = $sponsored;
        $this->outReason = $outReason;
        $this->manufacturerId = $manufacturerId;
        $this->create = $create;
    }

    public static function buy(
        BalloonId       $id,
        Uuid            $uuid,
        Immatriculation $immat,
        Model           $model,
        BuyDate         $buyDate,
        FlightTime      $flightTime,
        Weight          $weight,
        MarraineName    $marraine,
        Sponsored       $sponsored,
        ManufacturerId  $manufacturerId,
        Rowid           $author
    ): self
    {
        $balloon = new self(
            $id,
            $uuid,
            $immat,
            $model,
            $buyDate,
            $flightTime,
            $weight,
            $marraine,
            $sponsored,
            ReasonId::zero(),
            $manufacturerId,
            Create::now($author)
        );
        $balloon->recordThat(BalloonCreated::create($id));

        return $balloon;
    }

    public function id(): IdentifiableInterface
    {
        return $this->id;
    }

    public static function fromState(array $state): AggregateRootInterface
    {
        return new self(
            BalloonId::fromInt($state['id']),
            Uuid::fromString($state['uuid']),
            Immatriculation::fromString($state['immat']),
            Model::fromString($state['model']),
            BuyDate::fromString($state['buy_date']),
            FlightTime::fromInt($state['flight_time']),
            Weight::fromInt($state['weight']),
            MarraineName::fromName($state['marraine']),
            Sponsored::fromInt($state['sponsored']),
            ReasonId::fromInt($state['out_reason']),
            ManufacturerId::fromInt($state['manufacturer_id']),
            Create::create(
                Rowid::fromInt($state['creator']),
                $state['created_at']
            ),
        );
    }

    public function state(): array
    {
        return [
            'id' => $this->id->asString(),
            'uuid' => $this->uuid->asString(),
            'immat' => $this->immat->asString(),
            'model' => $this->model->asString(),
            'buy_date' => $this->buyDate->asString(),
            'flight_time' => $this->flightTime->time(),
            'weight' => $this->weight->asInt(),
            'marraine' => $this->marraine->asString(),
            'sponsored' => $this->sponsored->asInt(),
            'out_reason' => $this->outReason->asInt(),
            'manufacturer_id' => $this->manufacturerId->asString(),
            'creator' => $this->create->state()['creator'],
            'created_at' => $this->create->state()['at'],
        ];
    }

    public function correctFlightTime(FlightTime $time): self
    {
        $balloon = new $this(
            $this->id,
            $this->uuid,
            $this->immat,
            $this->model,
            $this->buyDate,
            $time,
            $this->weight,
            $this->marraine,
            $this->sponsored,
            $this->outReason,
            $this->manufacturerId,
            $this->create
        );

        $balloon->recordThat(BalloonFlightTimeCorrected::create($this->id));

        return $balloon;
    }

    public function fly(FlightTime $time): self
    {
        $balloon = new $this(
            $this->id,
            $this->uuid,
            $this->immat,
            $this->model,
            $this->buyDate,
            $this->flightTime->add($time),
            $this->weight,
            $this->marraine,
            $this->sponsored,
            $this->outReason,
            $this->manufacturerId,
            $this->create
        );

        $this->recordThat(BalloonFlew::create($this->id));

        return $balloon;
    }

    public function deprecate(ReasonId $reasonId): Balloon
    {
        $balloon = new $this(
            $this->id,
            $this->uuid,
            $this->immat,
            $this->model,
            $this->buyDate,
            $this->flightTime,
            $this->weight,
            $this->marraine,
            $this->sponsored,
            $reasonId,
            $this->manufacturerId,
            $this->create
        );

        $balloon->recordThat(BalloonDeprecated::create($this->id, $reasonId));

        return $balloon;
    }
}