<?php

namespace Laudeco\Dolibarr\FlightBalloon\Domain\Common\Repository;

use Laudeco\Dolibarr\FlightBalloon\Domain\Common\AggregateRootInterface;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity\IdentifiableInterface;

interface RepositoryInterface
{

    public function byId(IdentifiableInterface $id): AggregateRootInterface;

    public function save(AggregateRootInterface $aggregateRoot): void;

}