<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Basket\ValueObject;


use Webmozart\Assert\Assert;

final class Model
{

    private string $model;

    private function __construct(string $model)
    {
        Assert::stringNotEmpty($model);

        $this->model = $model;
    }

    public static function fromString(string $model): self
    {
        return new self($model);
    }

    public function __toString()
    {
        return $this->model;
    }

    public function asString(): string
    {
        return $this->model;
    }

}