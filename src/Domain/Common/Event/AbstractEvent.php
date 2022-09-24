<?php

namespace Laudeco\Dolibarr\FlightBalloon\Domain\Common\Event;

use Webmozart\Assert\Assert;

abstract class AbstractEvent implements DomainEventInterface
{

    private string $id;
    private \DateTimeImmutable $at;

    public function __construct(string $id)
    {
        Assert::stringNotEmpty($id, 'The ID of the event cannot be empty');

        $this->id = $id;
        $this->at = new \DateTimeImmutable();
    }

    public function id(): string
    {
        return $this->id;
    }

    public function at(): \DateTimeImmutable
    {
        return $this->at;
    }

    public function state(): array
    {
        return [
            'id' => $this->id,
            'at' => $this->at->format(\DateTimeInterface::ISO8601),
        ];
    }


}