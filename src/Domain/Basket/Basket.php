<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Basket;


use Laudeco\Dolibarr\FlightBalloon\Domain\Basket\ValueObject\BasketId;
use Laudeco\Dolibarr\FlightBalloon\Domain\Basket\ValueObject\BasketSerialNumber;
use Laudeco\Dolibarr\FlightBalloon\Domain\Basket\ValueObject\Comment;
use Laudeco\Dolibarr\FlightBalloon\Domain\Basket\ValueObject\EasyAccess;
use Laudeco\Dolibarr\FlightBalloon\Domain\Basket\ValueObject\Model;
use Laudeco\Dolibarr\FlightBalloon\Domain\Basket\ValueObject\Name;
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

final class Basket implements AggregateRootInterface
{

    use AggregateRoot;

    private BasketId $id;
    private Uuid $uuid;
    private BasketSerialNumber $serialNumber;
    private Model $model;
    private BuyDate $buyingDate;
    private Weight $weight;
    private FlightTime $flightTime;
    private Comment $comment;
    private Name $name;
    private EasyAccess $easyAccess;
    private ReasonId $reason;
    private ManufacturerId $manufacturerId;
    private Create $create;

    private function __construct(
        BasketId $id,
        Uuid $uuid,
        BasketSerialNumber $serialNumber,
        Model $model,
        BuyDate $buyingDate,
        Weight $weight,
        FlightTime $flightTime,
        Comment $comment,
        Name $name,
        EasyAccess $easyAccess,
        ReasonId $reason,
        ManufacturerId $manufacturerId,
        Create $create
    ) {
        $this->id = $id;
        $this->uuid = $uuid;
        $this->serialNumber = $serialNumber;
        $this->model = $model;
        $this->buyingDate = $buyingDate;
        $this->weight = $weight;
        $this->flightTime = $flightTime;
        $this->comment = $comment;
        $this->name = $name;
        $this->easyAccess = $easyAccess;
        $this->reason = $reason;
        $this->manufacturerId = $manufacturerId;
        $this->create = $create;
    }

    public static function easyAccess(
        BasketId $id,
        Uuid $uuid,
        BasketSerialNumber $serialNumber,
        Model $model,
        BuyDate $buyingDate,
        Weight $weight,
        FlightTime $flightTime,
        Comment $comment,
        Name $name,
        ReasonId $reason,
        ManufacturerId $manufacturerId,
        Create $create
    ): self {
        return new self(
            $id,
            $uuid,
            $serialNumber,
            $model,
            $buyingDate,
            $weight,
            $flightTime,
            $comment,
            $name,
            EasyAccess::YES(),
            $reason,
            $manufacturerId,
            $create
        );
    }

    public static function normal(
        BasketId $id,
        Uuid $uuid,
        BasketSerialNumber $serialNumber,
        Model $model,
        BuyDate $buyingDate,
        Weight $weight,
        FlightTime $flightTime,
        Comment $comment,
        Name $name,
        ReasonId $reason,
        ManufacturerId $manufacturerId,
        Create $create
    ): self {
        return new self(
            $id,
            $uuid,
            $serialNumber,
            $model,
            $buyingDate,
            $weight,
            $flightTime,
            $comment,
            $name,
            EasyAccess::NO(),
            $reason,
            $manufacturerId,
            $create
        );
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