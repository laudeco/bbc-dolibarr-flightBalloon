<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Manufacturer;


use Laudeco\Dolibarr\FlightBalloon\Domain\Common\AggregateRoot;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\AggregateRootInterface;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\IdentifiableInterface;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\Rowid;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\Uuid;
use Laudeco\Dolibarr\FlightBalloon\Domain\Manufacturer\Event\ManufacturerCreated;
use Laudeco\Dolibarr\FlightBalloon\Domain\Manufacturer\ViewModel\ManufacturerId;
use Laudeco\Dolibarr\FlightBalloon\Domain\Manufacturer\ViewModel\ManufacturerName;

final class Manufacturer implements AggregateRootInterface
{

    use AggregateRoot;

    private ManufacturerId $id;
    private Uuid $uuid;

    private ManufacturerName $name;
    private Rowid $supplier;

    private function __construct(ManufacturerId $id, Uuid $uuid, ManufacturerName $name, Rowid $supplier)
    {
        $this->id = $id;
        $this->uuid = $uuid;
        $this->name = $name;
        $this->supplier = $supplier;
    }

    public static function partener(ManufacturerId $id, Uuid $uuid, ManufacturerName $name, Rowid $supplier): self
    {
        $partener =  new self($id, $uuid, $name, $supplier);
        $partener->recordThat(ManufacturerCreated::create($id));

        return $partener;
    }


    public function id(): IdentifiableInterface
    {
        return $this->id;
    }

    public static function fromState(array $state): AggregateRootInterface
    {
        return new self(
            ManufacturerId::fromInt($state['id']),
            Uuid::fromString($state('uuid')),
            ManufacturerName::fromString($state['name']),
            Rowid::fromInt($state['supplier_id'])
        );
    }

    public function state(): array
    {
        return [
            'id' => $this->id->asInt(),
            'uuid' => $this->uuid->asString(),
            'name' => $this->name->asString(),
            'supplier_id' => $this->supplier->asInt(),
        ];
    }
}