<?php

namespace Laudeco\Dolibarr\FlightBalloon\Domain\Balloon;

use Laudeco\Dolibarr\FlightBalloon\Domain\Common\AggregateRoot;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\AggregateRootInterface;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\IdentifiableInterface;

final class Balloon implements AggregateRootInterface
{

    use AggregateRoot;

/*`rowid` INT(11) NOT NULL,
`immat` VARCHAR(10) NOT NULL,
`uuid` BINARY(16) NOT NULL,

`model` VARCHAR(30),
`buying_date` DATE NOT NULL DEFAULT '1999-01-01',
`flight_hours` TIME DEFAULT '00:00:00',
`weight` SMALLINT UNSIGNED DEFAULT 0,
`marraine` VARCHAR(45),
`sponsored` TINYINT(1) NOT NULL DEFAULT 0,
`out_reason_id` INT(11),
`manufacturer_id` INT(11) NOT NULL,
`created_by` INT(11) NOT NULL,
`created_at` DATETIME NOT NULL*/

    public function id(): IdentifiableInterface
    {
        // TODO: Implement id() method.
    }

    public function fromState(array $state): AggregateRootInterface
    {
        // TODO: Implement fromState() method.
    }

    public function state(): array
    {
        // TODO: Implement state() method.
    }

    public function equals($other): bool
    {
        // TODO: Implement equals() method.
    }
}