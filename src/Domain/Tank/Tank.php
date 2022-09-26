<?php

namespace Laudeco\Dolibarr\FlightBalloon\Tank;

use Laudeco\Dolibarr\FlightBalloon\Domain\Common\AggregateRoot;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\AggregateRootInterface;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\IdentifiableInterface;

final class Tank implements AggregateRootInterface
{
    use AggregateRoot;

    public function id(): IdentifiableInterface
    {
        // TODO: Implement id() method.
    }

    public static function fromState(array $state): AggregateRootInterface
    {
        // TODO: Implement fromState() method.
    }

    public function state(): array
    {
        // TODO: Implement state() method.
    }
}