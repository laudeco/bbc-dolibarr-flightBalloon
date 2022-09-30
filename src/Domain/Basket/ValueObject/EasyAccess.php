<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Basket\ValueObject;


final class EasyAccess
{
    private bool $easyAccess;

    private function __construct($easyAccess)
    {
        $this->easyAccess = $easyAccess;
    }


    public static function YES(): self
    {
        return new self(true);
    }


    public static function NO(): self
    {
        return new self(false);
    }

    public static function fromInt(int $easyAccess): self
    {
        return new self($easyAccess >= 1);
    }

    public function asInt(): int
    {
        return (int)$this->easyAccess;
    }
}