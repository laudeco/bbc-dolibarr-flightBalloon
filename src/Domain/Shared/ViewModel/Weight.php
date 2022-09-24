<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Shared\ViewModel;


use Webmozart\Assert\Assert;

final class Weight
{

    private int $weight;

    private function __construct(int $weight)
    {
        Assert::greaterThanEq($weight, 0);
        $this->weight = $weight;
    }

    public static function zero(): self
    {
        return new self(0);
    }

    public static function fromInt(int $weight): self
    {
        return new self($weight);
    }

    public function asInt(): int
    {
        return $this->weight;
    }


}