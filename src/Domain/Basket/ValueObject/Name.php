<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Basket\ValueObject;


use Webmozart\Assert\Assert;

final class Name
{
    private string $name;

    private function __construct(string $name)
    {
        Assert::stringNotEmpty($name);

        $this->name = $name;
    }

    public static function fromString(string $name): self
    {
        return new self($name);
    }

    public function __toString()
    {
        return $this->name;
    }

    public function asString(): string
    {
        return $this->name;
    }

}