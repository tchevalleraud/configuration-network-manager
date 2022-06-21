<?php
    namespace App\UI\AdminOffice\Authentication\Provider;

    use App\Application\Services\SettingService;
    use App\Domain\Local\System\Forms\SettingMicrosoft;
    use App\Infrastructure\Forms\AdminOffice\Authentication\Microsoft\EditForm;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("authentication/provider/microsoft", "authentication.provider.microsoft.")
     */
    class MicrosoftController extends AbstractController {

        /**
         * @Route(".html", name="index", methods={"GET", "POST"})
         */
        public function index(Request $request, SettingService $settingService){
            $settingMicrosoft = new SettingMicrosoft($settingService);

            $form = $this->createForm(EditForm::class, $settingMicrosoft);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $settingService->setSetting('security.microsoft.enabled', $settingMicrosoft->getSecurityMicrosoftEnabled());
                $settingService->setSetting('security.microsoft.client.id', $settingMicrosoft->getSecurityMicrosoftClientId());
                $settingService->setSetting('security.microsoft.client.secret', $settingMicrosoft->getSecurityMicrosoftClientSecret());
                $settingService->setSetting('security.microsoft.redirectUri', $settingMicrosoft->getSecurityMicrosoftRedirectUri());
                $settingService->setSetting('security.microsoft.url.authorize', $settingMicrosoft->getSecurityMicrosoftUrlAuthorize());
                $settingService->setSetting('security.microsoft.url.accessToken', $settingMicrosoft->getSecurityMicrosoftUrlAccessToken());
                $settingService->setSetting('security.microsoft.url.ressource', $settingMicrosoft->getSecurityMicrosoftUrlRessource());
                $settingService->setSetting('security.microsoft.scopes', $settingMicrosoft->getSecurityMicrosoftScopes());

                return $this->redirectToRoute('adminoffice.authentication.provider.microsoft.index');
            }

            return $this->render("AdminOffice/Authentication/Provider/Microsoft/index.html.twig", [
                'form'  => $form->createView()
            ]);
        }

    }