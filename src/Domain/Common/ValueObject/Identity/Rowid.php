<?php

namespace Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity;

use Webmozart\Assert\Assert;

final class Rowid implements IdentifiableInterface
{
    /**
     * @var int
     */
    private $value;

    public function __construct(string $value)
    {
        Assert::integerish($value);
        Assert::greaterThan($value, 0);

        $this->value = (int)$value;
    }


    public static function fromString(string $id): Rowid
    {
        return new self($id);
    }

    public function asString(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->asString();
    }

    public function equals(IdentifiableInterface $other): bool
    {
        return $this->asString() === $other->asString();
    }
}