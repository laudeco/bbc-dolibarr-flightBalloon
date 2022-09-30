<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Basket\Event;


use Laudeco\Dolibarr\FlightBalloon\Domain\Basket\ValueObject\BasketId;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\Event\AbstractEvent;

final class NormalBasketCreated extends AbstractBasketEvent
{
    private function __construct(BasketId $basketId)
    {
        parent::__construct($basketId, 'basket.normal.created');
    }

    public static function create(BasketId $basketId): self
    {
        return new self($basketId);
    }
}