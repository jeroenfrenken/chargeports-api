<?php


namespace App\Controller;


use App\Repository\ChargerRepository;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;
use App\Entity\Charger;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(
 *     "/api/charger"
 * )
 */
class ChargerController extends AbstractController
{
    /**
     * @Route("", methods={"GET"})
     *
     * @OA\Get(
     *     operationId="chargersAll"
     * )
     *
     * @OA\Response(
     *     response="200",
     *     description="Fetches the chargers",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=App\Entity\Charger::class, groups={"read"}))
     *     )
     * )
     *
     * @param ChargerRepository $chargerRepository
     * @return JsonResponse
     */
    public function chargers(ChargerRepository $chargerRepository)
    {
        return $this->json($chargerRepository->findChargers(), Response::HTTP_OK, [], [
            'groups' => 'read'
        ]);
    }
}