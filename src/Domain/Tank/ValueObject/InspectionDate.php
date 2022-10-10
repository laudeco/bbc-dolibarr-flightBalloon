<?php

namespace Laudeco\Dolibarr\FlightBalloon\Tank\ValueObject;

final class InspectionDate
{

    private \DateTimeImmutable $previous;
    private \DateTimeImmutable $next;

    private function __construct(\DateTimeImmutable $previous, \DateTimeImmutable $next)
    {
        $this->previous = $previous;
        $this->next = $next;
    }

    public static function fromString(string $previous, string $next): self
    {
        return new self(
            \DateTimeImmutable::createFromFormat('Y-m-d', $previous),
            \DateTimeImmutable::createFromFormat('Y-m-d', $next)
        );
    }

    private function format(\DateTimeImmutable $date): string
    {
        return $date->format('Y-m-d');
    }

    public function state(): array
    {
        return [
            'previous' => $this->format($this->previous),
            'next' => $this->format($this->next),
        ];
    }


}