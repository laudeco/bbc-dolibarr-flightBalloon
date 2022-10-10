<?php

namespace Laudeco\Dolibarr\FlightBalloon\Tank\Event;

use Laudeco\Dolibarr\FlightBalloon\Domain\Common\Event\AbstractEvent;
use Laudeco\Dolibarr\FlightBalloon\Tank\ValueObject\TankId;

abstract class AbstractTankEvent extends AbstractEvent
{
    private TankId $tankId;

    public function __construct(TankId $tankId, string $id)
    {
        parent::__construct($id);
        $this->tankId = $tankId;
    }

    public function tankId(): TankId
    {
        return $this->tankId;
    }

    public function state(): array
    {
        return array_merge(parent::state(), [
            'tank_id' => $this->tankId->asString(),
        ]);
    }
}