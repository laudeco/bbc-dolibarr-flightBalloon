<?php


namespace Laudeco\Dolibarr\FlightBalloon\Web\Http\Controller;


use Laudeco\Dolibarr\FlightBalloon\Web\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class HelloWorldController extends AbstractController
{

    public function __invoke(string $name): Response
    {
        return $this->render('helloWorld/try.html.twig', [
            'name' => $name
        ]);
    }

}