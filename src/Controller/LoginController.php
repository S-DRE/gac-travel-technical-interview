<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils, TranslatorInterface $translator): Response
    {

        $error = $authenticationUtils->getLastAuthenticationError();

        if ($error !== null) {
            $this->addFlash('error', $translator->trans('error.autenticacion'));
        }

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }
}
