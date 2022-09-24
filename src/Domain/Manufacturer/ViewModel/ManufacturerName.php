<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Manufacturer\ViewModel;


use Webmozart\Assert\Assert;

final class ManufacturerName
{

    private string $name;

    private function __construct(string $name)
    {
        Assert::string($name);
        $this->name = $name;
    }

    public static function fromString(string $name): self
    {
        return new self($name);
    }

    public function asString(): string
    {
        return $this->name;
    }

}