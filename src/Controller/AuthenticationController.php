<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use App\Model\LoginDTO;
use App\Model\RegisterDTO;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     *
     * @SWG\Post(
     *     operationId="authenticationLogin",
     *     security={},
     *     @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="LoginType",
     *          type="json",
     *          required=true,
     *          @Model(type=App\Form\LoginType::class)
     *     )
     * )
     *
     * @SWG\Response(
     *     response="200",
     *     description="Authentication success"
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(
        Request $request
    )
    {
        $data = new LoginDTO();

        $form = $this->createForm(LoginType::class, $data);
        $form->submit(json_decode($request->getContent(), true), true);

        if ($form->isSubmitted()) {
            return $this->json([
                'email' => $data->getEmail(),
                'password' => $data->getPassword(),
            ]);
        }

        return $this->json([
            'message' => 'Login'
        ]);
    }

    /**
     * @Route(
     *     "/register",
     *     methods={"POST"}
     * )
     *
     * @SWG\Post(
     *     operationId="authenticationRegister",
     *     security={},
     *     @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="RegisterType",
     *          type="json",
     *          required=true,
     *          @Model(type=App\Form\RegisterType::class)
     *     )
     * )
     *
     * @SWG\Response(
     *     response="200",
     *     description="Register success"
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(
        Request $request
    )
    {
        $data = new RegisterDTO();

        $form = $this->createForm(LoginType::class, $data);
        $form->submit(json_decode($request->getContent(), true), true);

        if ($form->isSubmitted()) {
            return $this->json([
                'email' => $data->getEmail(),
                'password' => $data->getPassword(),
            ]);
        }

        return $this->json([
            'message' => 'Register'
        ]);
    }

    /**
     * @Route(
     *     "/me",
     *     methods={"GET"}
     * )
     *
     * @SWG\Get(
     *     operationId="authenticationMe"
     * )
     *
     * @SWG\Response(
     *     response="200",
     *     description="Fetches the user"
     * )
     *
     * @SWG\Response(
     *     response="401",
     *     description="Authentication failed"
     * )
     *
     * @IsGranted("ROLE_USER")
     * @return JsonResponse
     */
    public function me()
    {
        /** @var User $user */
        $user = $this->getUser();

        return $this->json([
            'email' => $user->getEmail(),
        ]);
    }
}
