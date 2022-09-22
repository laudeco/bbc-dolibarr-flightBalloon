<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Balloon\ValueObject;


final class Model
{
    private string $model;

    private function __construct(string $model)
    {
        return $this->model = $model;
    }

    public static function fromString(string $model): self
    {
        return new self($model);
    }

    public static function empty(): self
    {
        return new self('');
    }

    public function asString(): string
    {
        return $this->model;
    }
}