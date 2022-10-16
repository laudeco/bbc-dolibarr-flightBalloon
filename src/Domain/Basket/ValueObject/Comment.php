<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Basket\ValueObject;


use Webmozart\Assert\Assert;

final class Comment
{
    private string $comment;

    private function __construct(string $serial)
    {
        $this->comment = $serial;
    }

    public static function zero(): self
    {
        return new self('');
    }

    public static function fromString(string $serial): self
    {
        return new self($serial);
    }

    public function __toString()
    {
        return $this->comment;
    }

    public function asString(): string
    {
        return $this->comment;
    }

}