<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserToken;
use App\Form\LoginType;
use App\Form\RegisterType;
use App\Model\LoginDTO;
use App\Model\RegisterDTO;
use App\Service\UserService;
use App\Util\GenerateUtil;
use Swagger\Annotations as SWG;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function login(
        Request $request,
        EntityManagerInterface $em,
        UserRepository $userRepository
    )
    {
        $loginDto = new LoginDTO();

        $form = $this->createForm(LoginType::class, $loginDto);
        $form->submit(json_decode($request->getContent(), true), true);

        if ($form->isSubmitted()) {
            $user = $userRepository->findOneByEmail($loginDto->getEmail());

            if ($user !== null && UserService::validatePassword($loginDto->getPassword(), $user->getPassword())) {
                $userToken = (new UserToken())
                    ->setUser($user)
                    ->setToken(GenerateUtil::generateApiToken());

                $em->persist($userToken);
                $em->flush();

                return $this->json([
                    'message' => $userToken->getToken()
                ]);
            }

            return $this->json([
                'message' => 'Email or Password not valid'
            ], Response::HTTP_BAD_REQUEST);
        }

        return $this->json([
            'message' => 'Error'
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
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
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return JsonResponse
     */
    public function register(
        EntityManagerInterface $em,
        Request $request
    )
    {
        $data = new RegisterDTO();

        $form = $this->createForm(RegisterType::class, $data);
        $form->submit(json_decode($request->getContent(), true), true);

        if ($form->isSubmitted()) {
            $user = (new User())
                ->setEmail($data->getEmail())
                ->setFirstName($data->getFirstName())
                ->setLastName($data->getLastName())
                ->setPassword(UserService::hashPassword($data->getPassword()));

            $userToken = (new UserToken())
                ->setUser($user)
                ->setToken(GenerateUtil::generateApiToken());

            $em->persist($user);
            $em->persist($userToken);
            $em->flush();

            return $this->json([
                'message' => $userToken->getToken()
            ]);
        }

        return $this->json([
            'message' => 'Error'
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
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
