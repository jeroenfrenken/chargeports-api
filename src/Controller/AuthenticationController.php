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
use OpenApi\Annotations as OA;
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
     * @OA\Post(
     *     operationId="authenticationLogin",
     *     security={}
     * )
     *
     * @OA\RequestBody(
     *     @Model(type=App\Form\LoginType::class)
     * )
     *
     * @OA\Response(
     *     response="200",
     *     description="Authentication success",
     *     @OA\JsonContent(
     *       @OA\Property(property="token", type="string"),
     *     )
     * )
     *
     * @OA\Response(
     *     response="400",
     *     description="Authentication failed because of credentials",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string"),
     *     )
     * )
     *
     * @OA\Response(
     *     response="500",
     *     description="Authentication failed because of server error",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string"),
     *     )
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
                    'token' => $userToken->getToken()
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
     * @OA\Post(
     *     operationId="authenticationRegister",
     *     security={}
     * )
     *
     * @OA\RequestBody(
     *     @Model(type=App\Form\RegisterType::class)
     * )
     *
     * @OA\Response(
     *     response="200",
     *     description="Register success",
     *     @OA\JsonContent(
     *       @OA\Property(property="token", type="string"),
     *     )
     * )
     *
     * @OA\Response(
     *     response="400",
     *     description="Register failed because of credentials",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string"),
     *     )
     * )
     *
     * @OA\Response(
     *     response="500",
     *     description="Register failed because of server error",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string"),
     *     )
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
                'token' => $userToken->getToken()
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
     * @OA\Get(
     *     operationId="authenticationMe"
     * )
     *
     * @OA\Response(
     *     response="200",
     *     description="Fetches the user",
     *     @Model(type=App\Entity\User::class, groups={"read"})
     * )
     *
     * @OA\Response(
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

        return $this->json($user, Response::HTTP_OK, [], [
            'groups' => 'read'
        ]);
    }
}
