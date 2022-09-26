<?php

namespace Laudeco\Dolibarr\FlightBalloon\Domain\Balloon\Event;

use Laudeco\Dolibarr\FlightBalloon\Domain\Balloon\ValueObject\BalloonId;
use Laudeco\Dolibarr\FlightBalloon\Domain\Shared\ViewModel\ReasonId;

final class BalloonDeprecated extends AbstractBalloonEvent
{

    private ReasonId $reasonId;

    private function __construct(BalloonId $balloonId, ReasonId $reason)
    {
        parent::__construct($balloonId, 'balloon.deprecated');

        $this->reasonId = $reason;
    }

    public static function create(BalloonId $balloonId, ReasonId $reason): self
    {
        return new self($balloonId, $reason);
    }

    public function reasonId(): ReasonId
    {
        return $this->reasonId;
    }

    public function state(): array
    {
        return array_merge(parent::state(), [
            'reason_id' => $this->reasonId->asInt(),
        ]);
    }


}