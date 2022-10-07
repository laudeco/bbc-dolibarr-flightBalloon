<?php

namespace Laudeco\Dolibarr\FlightBalloon\Tank\ValueObject;

final class Serial
{
    private string $serial;

    private function __construct(string $serial)
    {
        return $this->serial = $serial;
    }

    public static function fromSerial(string $name): self
    {
        return new self($name);
    }

    public static function empty(): self
    {
        return new self('');
    }

    public function asString(): string
    {
        return $this->serial;
    }
}