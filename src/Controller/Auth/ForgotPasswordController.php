<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Entity\Auth\User;
use App\Form\Auth\ForgotPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use MsgPhp\User\Command\RequestUserPasswordCommand;
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
 * @Route("/auth/password/forgot", name="forgot_password")
 */
final class ForgotPasswordController
{
    public function __invoke(
        Request $request,
        UrlGeneratorInterface $urlGenerator,
        FormFactoryInterface $formFactory,
        FlashBagInterface $flashBag,
        Environment $twig,
        MessageBusInterface $bus,
        EntityManagerInterface $em
    ): Response {
        $form = $formFactory->createNamed('', ForgotPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $em->getRepository(User::class)->findOneBy(['credential.email' => $form->getData()['email']]);
            $bus->dispatch(new RequestUserPasswordCommand($user->getId()));
            $flashBag->add('success', 'You\'re password is requested.');

            return new RedirectResponse($urlGenerator->generate('login'));
        }

        return new Response($twig->render('user/forgot_password.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}
