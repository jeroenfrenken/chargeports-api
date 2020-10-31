<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Model\ReservationDTO;
use App\Repository\ReservationRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ReservationController
 * @package App\Controller
 *
 * @Route("/api/reservation")
 */
class ReservationController extends AbstractController
{
    /**
     * @Route("", methods={"POST"})
     *
     * @OA\Post(
     *     operationId="reservationCreate"
     * )
     *
     * @OA\RequestBody(
     *     @Model(type=App\Form\ReservationType::class)
     * )
     *
     * @OA\Response(
     *     response="200",
     *     description="Created the reservation",
     *     @Model(type=App\Entity\Reservation::class, groups={"read"})
     * )
     *
     * @IsGranted("ROLE_USER")
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return JsonResponse
     * @throws Exception
     */
    public function createReservation(Request $request, EntityManagerInterface $em)
    {
        $reservationDto = new ReservationDTO();

        $data = json_decode($request->getContent(), true);

        $form = $this->createForm(ReservationType::class, $reservationDto);
        $form->submit($data, true);

        if ($form->isSubmitted()) {
            $reservation = (new Reservation())
                ->setUser($this->getUser())
                ->setChargerConnection($reservationDto->getChargerConnection())
                ->setStartTime(new DateTime($data['startTime']))
                ->setEndTime(new DateTime($data['endTime']));

            $em->persist($reservation);
            $em->flush();

            return $this->json($reservation, Response::HTTP_OK, [], [
                'groups' => 'read'
            ]);
        }

        return $this->json([
            'message' => 'Error'
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @Route("/previous", methods={"GET"})
     *
     * @OA\Get(
     *     operationId="previousReservations"
     * )
     *
     * @OA\Response(
     *     response="200",
     *     description="Fetches the previous reservations",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=App\Entity\Reservation::class, groups={"read"}))
     *     )
     * )
     *
     * @IsGranted("ROLE_USER")
     *
     * @param ReservationRepository $repository
     * @return JsonResponse
     */
    public function previousReservation(ReservationRepository $repository)
    {
        return $this->json($repository->findBeforeTime(new DateTime(), $this->getUser()), Response::HTTP_OK, [], [
            'groups' => 'read'
        ]);
    }

    /**
     * @Route("/upcoming", methods={"GET"})
     *
     * @OA\Get(
     *     operationId="upcomingReservations"
     * )
     *
     * @OA\Response(
     *     response="200",
     *     description="Fetches the upcoming reservations",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=App\Entity\Reservation::class, groups={"read"}))
     *     )
     * )
     *
     * @IsGranted("ROLE_USER")
     *
     * @param ReservationRepository $repository
     * @return JsonResponse
     */
    public function upComingReservation(ReservationRepository $repository)
    {
        return $this->json($repository->findAfterTime(new DateTime(), $this->getUser()), Response::HTTP_OK, [], [
            'groups' => 'read'
        ]);
    }
}
