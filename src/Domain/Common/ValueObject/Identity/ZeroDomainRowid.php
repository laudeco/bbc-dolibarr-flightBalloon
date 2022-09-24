<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity;


trait ZeroDomainRowid
{
    private ?Rowid $id;

    private function __construct(Rowid $id = null)
    {
        $this->id = $id;
    }

    public static function fromString(?string $id): ZeroDomainRowid
    {
        if (null === $id) {
            return new self();
        }

        return new self(Rowid::fromString($id));
    }

    public static function zero(): self
    {
        return new self(null);
    }

    public static function fromInt(int $reason): self
    {
        return new self(Rowid::fromString('' . $reason));
    }

    public function asString(): string
    {
        if (null === $this->id) {
            return '0';
        }

        return $this->id->asString();
    }

    public function equals(IdentifiableInterface $other): bool
    {
        if (null === $this->id) {
            return false;
        }

        return $other->equals($this->id);
    }

    public function asInt(): int
    {
        return (int)$this->asString();
    }

}