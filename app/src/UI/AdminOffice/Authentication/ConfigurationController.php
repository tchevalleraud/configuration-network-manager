<?php
    namespace App\UI\AdminOffice\Authentication;

    use App\Application\Services\SettingService;
    use App\Domain\Local\System\Forms\SettingGlobal;
    use App\Infrastructure\Forms\AdminOffice\Authentication\Configuration\EditForm;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("authentication/configuration", name="authentication.configuration.")
     */
    class ConfigurationController extends AbstractController {

        /**
         * @Route(".html", name="index", methods={"GET", "POST"})
         */
        public function index(Request $request, SettingService $settingService){
            $settingGlobal = new SettingGlobal($settingService);
            $form = $this->createForm(EditForm::class, $settingGlobal);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $settingService->setSetting('security.session.idle', $settingGlobal->getSecuritySessionIdle());

                return $this->redirectToRoute("adminoffice.authentication.configuration.index");
            }

            return $this->render("AdminOffice/Authentication/Configuration/index.html.twig", [
                'form'  => $form->createView()
            ]);
        }

    }