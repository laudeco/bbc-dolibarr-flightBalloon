<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity;


trait DomainRowid
{
    private Rowid $id;

    private function __construct(Rowid $id)
    {
        $this->id = $id;
    }

    public static function fromString(string $id): DomainRowid
    {
        return new self(Rowid::fromString($id));
    }

    public static function fromInt(int $id): DomainRowid
    {
        return new self(Rowid::fromInt($id));
    }

    public function asString(): string
    {
        return $this->id->asString();
    }

    public function equals(IdentifiableInterface $other): bool
    {
        return $this->id->equals($other);
    }

    public function asInt(): int
    {
        return $this->asInt();
    }
}