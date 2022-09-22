<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Common\Event;


interface DomainEventInterface
{

    /**
     * Gets the event id.
     *
     * @return string
     */
    public function id(): string;

    public function at(): \DateTimeImmutable;

    public function state(): array;

}