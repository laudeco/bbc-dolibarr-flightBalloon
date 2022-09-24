<?php

namespace Laudeco\Dolibarr\FlightBalloon\Domain\Common;

use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\IdentifiableInterface;

interface AggregateRootInterface
{

    public function id(): IdentifiableInterface;

    public static function fromState(array $state): AggregateRootInterface;

    public function state(): array;

    public function equals(AggregateRootInterface $other): bool;

}