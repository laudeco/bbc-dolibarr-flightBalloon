<?php

namespace Laudeco\Dolibarr\FlightBalloon\Tank\ValueObject;

use Webmozart\Assert\Assert;

final class Capacity
{

    private int $value;

    private function __construct(int $value)
    {
        Assert::greaterThan($value, 0);
        $this->value = $value;
    }

    public static function fromInt(int $value): self
    {
        return new self($value);
    }

    public function asInt():int{
        return $this->value;
    }

}