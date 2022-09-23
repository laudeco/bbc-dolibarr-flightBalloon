<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Shared\ViewModel;


use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\IdentifiableInterface;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\Rowid;

final class ReasonId implements IdentifiableInterface
{
    private Rowid $id;

    private function __construct(Rowid $id)
    {
        $this->id = $id;
    }

    public static function fromString(string $id): IdentifiableInterface
    {
        return new self(Rowid::fromString($id));
    }

    public function asString(): string
    {
        return $this->id->asString();
    }

    public function equals(IdentifiableInterface $other): bool
    {
        return $this->id->equals($other);
    }
}