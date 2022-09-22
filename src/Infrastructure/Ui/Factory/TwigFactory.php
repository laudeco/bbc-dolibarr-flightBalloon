<?php


namespace Laudeco\Dolibarr\FlightBalloon\Infrastructure\Ui\Factory;


use Twig\Environment;

final class TwigFactory
{

    public static function create(string $rootDir): Environment
    {
        $loader = new \Twig\Loader\FilesystemLoader('templates', $rootDir);
        return new \Twig\Environment($loader);
    }

}