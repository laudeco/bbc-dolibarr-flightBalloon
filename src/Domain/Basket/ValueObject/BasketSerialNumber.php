<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Basket\ValueObject;


use Webmozart\Assert\Assert;

final class BasketSerialNumber
{

    private string $serial;

    private function __construct(string $serial)
    {
        Assert::stringNotEmpty($serial);

        $this->serial = $serial;
    }

    public static function fromString(string $serial): self
    {
        return new self($serial);
    }

    public function __toString()
    {
        return $this->serial;
    }

    public function asString(): string
    {
        return $this->serial;
    }

}