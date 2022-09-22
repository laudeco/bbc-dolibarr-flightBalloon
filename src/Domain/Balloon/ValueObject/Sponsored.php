<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Balloon\ValueObject;


final class Sponsored
{

    private bool $isSponsored;

    private function __construct(bool $isSponsored)
    {
        $this->isSponsored = $isSponsored;
    }

    public static function fromInt(int $sponsored): self
    {
        return new self($sponsored >= 1);
    }

    public static function sponsored(): self
    {
        return new self(true);
    }

    public static function neutral(): self
    {
        return new self(false);
    }

    public function asInt(): int
    {
        return (int)$this->isSponsored;
    }

    public function isSponsored(): bool
    {
        return $this->isSponsored;
    }


}