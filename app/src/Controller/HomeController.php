<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route("/", name="home")
 */
class HomeController
{
    public function __invoke(Environment $twig): Response
    {
        return new Response($twig->render('home.html.twig'));
    }

}
