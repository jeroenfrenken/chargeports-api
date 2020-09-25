<?php


namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AuthenticationController extends AbstractController
{

    /**
     * @Route(
     *     "/login"
     * )
     */
    public function login()
    {
        return $this->json([
            'message' => 'Login'
        ]);
    }

    /**
     * @Route(
     *     "/me"
     * )
     *
     * @IsGranted("ROLE_USER")
     */
    public function me()
    {
        return $this->json([
            'message' => 'Welcome',
            'email' => $this->getUser()->getEmail(),
        ]);
    }
}
