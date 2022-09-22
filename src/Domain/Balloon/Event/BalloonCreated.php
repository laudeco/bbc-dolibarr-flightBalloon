<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Balloon\Event;


use Laudeco\Dolibarr\FlightBalloon\Domain\Common\Event\AbstractEvent;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\Rowid;

final class BalloonCreated extends AbstractEvent
{

    private Rowid $balloonId;

    private function __construct(Rowid $balloonId)
    {
        parent::__construct('balloon.created');

        $this->balloonId = $balloonId;
    }


    public static function create(Rowid $balloonId): self
    {
        return new self($balloonId);
    }

    public function state(): array
    {
        return [
            'balloon_id' => $this->balloonId->asString(),
        ];
    }
}