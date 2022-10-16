<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Basket;


use Laudeco\Dolibarr\FlightBalloon\Domain\Basket\Event\BasketEasyAccessCreated;
use Laudeco\Dolibarr\FlightBalloon\Domain\Basket\Event\NormalBasketCreated;
use Laudeco\Dolibarr\FlightBalloon\Domain\Basket\ValueObject\BasketId;
use Laudeco\Dolibarr\FlightBalloon\Domain\Basket\ValueObject\BasketSerialNumber;
use Laudeco\Dolibarr\FlightBalloon\Domain\Basket\ValueObject\Comment;
use Laudeco\Dolibarr\FlightBalloon\Domain\Basket\ValueObject\EasyAccess;
use Laudeco\Dolibarr\FlightBalloon\Domain\Basket\ValueObject\Model;
use Laudeco\Dolibarr\FlightBalloon\Domain\Basket\ValueObject\Name;
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
        $basket = new self(
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

        $basket->recordThat(BasketEasyAccessCreated::create($id));

        return $basket;
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
        $basket = new self(
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

        $basket->recordThat(NormalBasketCreated::create($id));

        return $basket;
    }


    public function id(): IdentifiableInterface
    {
        return $this->id;
    }

    public static function fromState(array $state): AggregateRootInterface
    {
        return new self(
            BasketId::fromInt($state['id']),
            Uuid::fromString($state['uuid']),
            BasketSerialNumber::fromString($state['serial_number']),
            Model::fromString($state['model']),
            BuyDate::fromString($state['buying_date']),
            Weight::fromInt($state['weight']),
            FlightTime::fromInt($state['flight_time']),
            Comment::fromString($state['comment']),
            Name::fromString($state['name']),
            EasyAccess::fromInt($state['easy_access']),
            ReasonId::fromInt($state['out_reason']),
            ManufacturerId::fromInt($state['manufacturer_id']),
            Create::create(Rowid::fromInt($state['creator']), $state['created_at'])
        );
    }

    public function state(): array
    {
        return [
            'id' => $this->id->asInt(),
            'uuid' => $this->uuid->asString(),
            'serial_number' => $this->serialNumber->asString(),
            'model' => $this->model->asString(),
            'buying_date' => $this->buyingDate->asString(),
            'weight' => $this->weight->asInt(),
            'flight_time' => $this->flightTime->time(),
            'comment' => $this->comment->asString(),
            'name' => $this->name->asString(),
            'easy_access' => $this->easyAccess->asInt(),
            'out_reason' => $this->reason->asInt(),
            'manufacturer_id' => $this->manufacturerId->asInt(),
            'creator' => $this->create->state()['creator'],
            'created_at' => $this->create->state()['at'],
        ];
    }
}