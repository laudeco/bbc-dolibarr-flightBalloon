<?php


namespace Laudeco\Dolibarr\FlightBalloon\Domain\Common\ValueObject\Identity;


interface IdentityGeneratorInterface
{

    public function generate(): IdentifiableInterface;

}