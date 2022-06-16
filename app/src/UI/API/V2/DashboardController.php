<?php
    namespace App\UI\API\V2;

    use App\UI\API\APIExtendController;
    use OpenApi\Annotations as OA;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("", name="dashboard.")
     */
    class DashboardController extends APIExtendController {

        /**
         * @OA\Get(
         *     path="/",
         *     security={{"bearerAuth":{}}},
         *     tags={"Default"},
         *     @OA\Response(
         *         response=200,
         *         description="200 - OK",
         *         @OA\JsonContent(
         *             @OA\Property(property="response", type="array", @OA\Items(), ref="#/components/schemas/Response200")
         *         )
         *     )
         * )
         * @Route("/", name="index", methods={"GET"})
         */
        public function index(){
            return new JsonResponse([
                'date'  => (new \DateTime())->format("Y/m/d H:i:s")
            ]);
        }

    }