<?php

namespace Laudeco\Dolibarr\FlightBalloon\Tank\Event;

use Laudeco\Dolibarr\FlightBalloon\Tank\ValueObject\TankId;

final class TankFlew extends AbstractTankEvent
{
    private function __construct(TankId $tankId)
    {
        parent::__construct($tankId, 'tank.flew');
    }

    public static function create(TankId $tankId): self
    {
        return new self($tankId);
    }
}