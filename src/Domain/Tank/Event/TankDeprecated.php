<?php

namespace Laudeco\Dolibarr\FlightBalloon\Tank\Event;

use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\Rowid;
use Laudeco\Dolibarr\FlightBalloon\Domain\Shared\ViewModel\ReasonId;
use Laudeco\Dolibarr\FlightBalloon\Tank\ValueObject\TankId;

class TankDeprecated extends AbstractTankEvent
{

    private ReasonId $reason;
    private Rowid $author;

    private function __construct(TankId $tankId, ReasonId $reasonId, Rowid $author)
    {
        parent::__construct($tankId, 'tank.deprecated');

        $this->reason = $reasonId;
        $this->author = $author;
    }

    public static function create(TankId $tankId, ReasonId $reasonId, Rowid $author): self
    {
        return new self($tankId, $reasonId, $author);
    }

    public function state(): array
    {
        return array_merge(parent::state(), [
            'author' => $this->author->asInt(),
            'reason' => $this->reason->asString(),
        ]);
    }


}