<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Form\Auth\RegisterType;
use MsgPhp\User\Command\CreateUserCommand;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

/**
 * @Route("/auth/register", name="register")
 */
final class RegisterController
{
    public function __invoke(
        Request $request,
        UrlGeneratorInterface $urlGenerator,
        FormFactoryInterface $formFactory,
        FlashBagInterface $flashBag,
        Environment $twig,
        MessageBusInterface $bus
    ): Response {
        $form = $formFactory->createNamed('', RegisterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bus->dispatch(new CreateUserCommand($form->getData()));
            $flashBag->add('success', 'You\'re successfully registered.');

            return new RedirectResponse($urlGenerator->generate('login'));
        }

        return new Response($twig->render('user/register.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}
