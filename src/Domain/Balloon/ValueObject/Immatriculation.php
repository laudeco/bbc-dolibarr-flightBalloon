<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Balloon\ValueObject;


use Webmozart\Assert\Assert;

final class Immatriculation
{

    private string $value;

    private function __construct(string $value)
    {
        Assert::stringNotEmpty($value);
        Assert::contains($value, '-');
        Assert::notContains($value, ' ');

        $this->value = $value;
    }

    public static function fromString(string $immatriculation): self
    {
        return new self($immatriculation);
    }

    public function asString(): string
    {
        return $this->value;
    }


}