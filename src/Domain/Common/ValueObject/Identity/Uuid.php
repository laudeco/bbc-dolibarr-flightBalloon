<?php

namespace Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity;

use Webmozart\Assert\Assert;

final class Uuid implements IdentifiableInterface
{
    /**
     * @var string
     */
    private $value;

    private function __construct(string $id)
    {
        Assert::uuid($id);
        $this->value = $id;
    }

    public static function fromString(string $id)
    {
        return new self($id);
    }

    public function asString(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(IdentifiableInterface $other): bool
    {
        return $this->value === $other->asString();
    }
}