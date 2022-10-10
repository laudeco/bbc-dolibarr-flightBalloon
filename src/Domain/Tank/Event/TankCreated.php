<?php

namespace Laudeco\Dolibarr\FlightBalloon\Tank\Event;

use Laudeco\Dolibarr\FlightBalloon\Domain\Balloon\ValueObject\BalloonId;
use Laudeco\Dolibarr\FlightBalloon\Tank\ValueObject\TankId;

final class TankCreated extends AbstractTankEvent
{
    private function __construct(TankId $tankId)
    {
        parent::__construct($tankId, 'tank.created');
    }

    public static function create(TankId $tankId): self
    {
        return new self($tankId);
    }
}