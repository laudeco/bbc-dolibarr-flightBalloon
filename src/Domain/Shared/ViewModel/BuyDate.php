<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Shared\ViewModel;


use Webmozart\Assert\Assert;

final class BuyDate
{
    private \DateTimeImmutable $date;

    private function __construct(\DateTimeImmutable $date)
    {
        Assert::lessThanEq($date, new \DateTimeImmutable());
        $this->date = $date;
    }

    public static function now():self{
        return new self(new \DateTimeImmutable());
    }

    public static function fromString(string $date):self{
        return new self(\DateTimeImmutable::createFromFormat('Y-m-d', $date));
    }

    public function asString():string{
        return $this->date->format('Y-m-d');
    }


}