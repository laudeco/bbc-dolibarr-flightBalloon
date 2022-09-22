<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity;

interface IdentifiableInterface
{

    public static function fromString(string $id);

    public function asString(): string;

    public function equals(IdentifiableInterface $other): bool;
}