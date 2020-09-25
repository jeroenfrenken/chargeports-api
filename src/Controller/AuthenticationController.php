<?php


namespace App\Controller;


use Nelmio\ApiDocBundle\Annotation\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class AuthenticationController extends AbstractController
{

    /**
     * @Route(
     *     "/login",
     *     methods={"POST"}
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
     *     "/me",
     *     methods={"GET"}
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
