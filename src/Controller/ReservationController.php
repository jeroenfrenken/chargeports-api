<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\User;
use App\Form\ReservationType;
use App\Model\ReservationDTO;
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
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

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
     * @OA\Get(
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
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=App\Entity\Reservation::class, groups={"read"}))
     *     )
     * )
     *
     * @IsGranted("ROLE_USER")
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param UserInterface $user
     * @return JsonResponse
     * @throws Exception
     */
    public function createReservation(Request $request, EntityManagerInterface $em, UserInterface $user)
    {
        $reservationDto = new ReservationDTO();

        $data = json_decode($request->getContent(), true);

        $form = $this->createForm(ReservationType::class, $reservationDto);
        $form->submit($data, true);

        if ($form->isSubmitted()) {
            $reservation = (new Reservation())
                ->setUser($user)
                ->setChargerConnection($reservationDto->getChargerConnection())
                ->setStartTime(new DateTime($data['startTime']))
                ->setEndTime(new DateTime($data['endTime']));

            $em->persist($reservation);
            $em->flush();

            return $this->json($reservation,Response::HTTP_OK, [], [
                'groups' => 'read'
            ]);
        }

        return $this->json([
            'message' => 'Error'
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
