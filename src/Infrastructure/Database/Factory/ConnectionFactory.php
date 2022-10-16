<?php


namespace Laudeco\Dolibarr\FlightBalloon\Infrastructure\Database\Factory;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Twig\Environment;

final class ConnectionFactory
{
    public static function create(string $database, string $user, string $password, string $host, string $port): Connection
    {
        return DriverManager::getConnection([
            'dbname' => $database,
            'user' => $user,
            'password' => $password,
            'host' => $host,
            'driver' => 'pdo_mysql',
            'port' => $port,
        ]);

    }
}