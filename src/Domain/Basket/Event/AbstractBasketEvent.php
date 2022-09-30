<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Basket\Event;


use Laudeco\Dolibarr\FlightBalloon\Domain\Basket\ValueObject\BasketId;
use Laudeco\Dolibarr\FlightBalloon\Domain\Common\Event\AbstractEvent;

abstract class AbstractBasketEvent extends AbstractEvent
{

    private BasketId $basketId;

    public function __construct(BasketId $basketId, string $id)
    {
        parent::__construct($id);

        $this->basketId = $basketId;
    }

    public function state(): array
    {
        return array_merge(parent::state(), [
            'basket_id' => $this->basketId->asString()
        ]);
    }


}