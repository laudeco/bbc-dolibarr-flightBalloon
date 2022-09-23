<?php

namespace Laudeco\Dolibarr\FlightBalloon\Domain\Balloon\Event;

use Laudeco\Dolibarr\FlightBalloon\Domain\Balloon\ValueObject\BalloonId;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\Event\AbstractEvent;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\Rowid;

final class BalloonFlew extends AbstractBalloonEvent
{

    private function __construct(BalloonId $balloonId)
    {
        parent::__construct($balloonId, 'balloon.flew');
    }

    public static function create(BalloonId $balloonId): self
    {
        return new self($balloonId);
    }
}