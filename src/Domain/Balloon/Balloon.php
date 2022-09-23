<?php

namespace Laudeco\Dolibarr\FlightBalloon\Domain\Balloon;

use Laudeco\Dolibarr\FlightBalloon\Domain\Balloon\Event\BalloonFlew;
use Laudeco\Dolibarr\FlightBalloon\Domain\Balloon\ValueObject\BalloonId;
use Laudeco\Dolibarr\FlightBalloon\Domain\Balloon\ValueObject\Immatriculation;
use Laudeco\Dolibarr\FlightBalloon\Domain\Balloon\ValueObject\MarraineName;
use Laudeco\Dolibarr\FlightBalloon\Domain\Balloon\ValueObject\Model;
use Laudeco\Dolibarr\FlightBalloon\Domain\Balloon\ValueObject\Sponsored;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\AggregateRoot;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\AggregateRootInterface;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\IdentifiableInterface;
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

    private function __construct(BalloonId $id, Uuid $uuid, Immatriculation $immat, Model $model, BuyDate $buyDate, FlightTime $flightTime, Weight $weight, MarraineName $marraine, Sponsored $sponsored, ReasonId $outReason, ManufacturerId $manufacturerId, Create $create)
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

    public function id(): IdentifiableInterface
    {
        return $this->id;
    }

    public function fromState(array $state): AggregateRootInterface
    {
        // TODO: Implement fromState() method.
    }

    public function state(): array
    {
        return [

        ];
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
}