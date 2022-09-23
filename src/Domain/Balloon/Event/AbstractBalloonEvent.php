<?php

namespace Laudeco\Dolibarr\FlightBalloon\Domain\Balloon\Event;

use Laudeco\Dolibarr\FlightBalloon\Domain\Balloon\ValueObject\BalloonId;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\Event\AbstractEvent;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\Rowid;

abstract class AbstractBalloonEvent extends AbstractEvent
{
    private BalloonId $balloonId;

    public function __construct(BalloonId $balloonId, string $id)
    {
        parent::__construct($id);
        $this->balloonId = $balloonId;
    }

    public function balloonId(): BalloonId
    {
        return $this->balloonId;
    }

    public function state(): array
    {
        return array_merge(parent::state(), [
            'balloon_id' => $this->balloonId->asString(),
        ]);
    }
}