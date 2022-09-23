<?php

namespace Laudeco\Dolibarr\FlightBalloon\Domain\Common;

use Laudeco\Dolibarr\FlightBalloon\Domain\Common\Event\DomainEventInterface;

trait AggregateRoot
{

    /**
     * @var array | DomainEventInterface[]
     */
    private array $events = [];

    private function recordThat(DomainEventInterface $event): void
    {
        $this->events[] = $event;
    }

    /**
     * @return array|DomainEventInterface[]
     */
    public function events(): array
    {
        return $this->events;
    }

    public function clearEvents(): void
    {
        $this->events = [];
    }

    public function equals(AggregateRootInterface $other): bool
    {
        return get_class($this) === get_class($other)
            && $this->id() === $other->id();
    }

}