<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Shared\ViewModel;


use Webmozart\Assert\Assert;

final class FlightTime
{
    private int $minutes;

    private function __construct(int $minute)
    {
        Assert::greaterThanEq($minute, 0);
        $this->minutes = $minute;
    }

    public static function zero(): self
    {
        return new self(0);
    }

    public static function fromString(string $minute): self
    {
        Assert::integerish($minute);
        return new self((int)$minute);
    }

    public static function fromInt(int $minute): self
    {
        return new self($minute);
    }

    public function addTime(\DateTimeInterface $dateTime): self
    {
        $hours = (int)$dateTime->format('H') * 60;
        $minutes = (int)$dateTime->format('i');

        return new $this($this->minutes + $hours + $minutes);
    }

    public function add(FlightTime $minutes): self
    {
        return new $this($this->minutes + $minutes->time());
    }

    public function time(): int
    {
        return $this->minutes;
    }


}