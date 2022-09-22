<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Balloon\ValueObject;


final class MarraineName
{

    private string $name;

    private function __construct(string $name)
    {
        return $this->name = $name;
    }

    public static function fromName(string $name): self
    {
        return new self($name);
    }

    public static function empty(): self
    {
        return new self('');
    }

    public function asString(): string
    {
        return $this->name;
    }


}