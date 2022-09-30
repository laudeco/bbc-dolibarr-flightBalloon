<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Basket\Event;


use Laudeco\Dolibarr\FlightBalloon\Domain\Balloon\ValueObject\BalloonId;
use Laudeco\Dolibarr\FlightBalloon\Domain\Basket\ValueObject\BasketId;

final class BasketEasyAccessCreated extends AbstractBasketEvent
{

    private function __construct(BasketId $basketId)
    {
        parent::__construct($basketId, 'basket.easy_access.created');
    }

    public static function create(BasketId $basketId): self
    {
        return new self($basketId);
    }
}