<?php declare(strict_types=1);

namespace App\Auth\Delivery\App\Controllers;

use App\Resources\Delivery\App\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{

    public function __invoke(Request $request, AuthenticationUtils $utils)
    {
        return $this->render('auth/login.html.twig', [
            'error'         => $utils->getLastAuthenticationError(),
            'last_username' => $utils->getLastUsername(),
        ]);
    }
}
