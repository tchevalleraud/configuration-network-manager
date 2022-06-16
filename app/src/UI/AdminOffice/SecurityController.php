<?php
    namespace App\UI\AdminOffice;

    use App\Application\Services\SettingService;
    use League\OAuth2\Client\Provider\GenericProvider;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Session\Session;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

    /**
     * @Route("", name="security.")
     */
    class SecurityController extends AbstractController {

        /**
         * @Route("login.html", name="login")
         */
        public function login(AuthenticationUtils $authenticationUtils){
            $error = $authenticationUtils->getLastAuthenticationError();

            return $this->render("AdminOffice/Security/login.html.twig", [
                'error'         => $error
            ]);
        }

        /**
         * @Route("logout.html", name="logout")
         */
        public function logout(){
        }

        /**
         * @Route("login/microsoft.html", name="login.microsoft", methods={"GET"})
         */
        public function loginMicrosoft(Session $session, SettingService $settingService){
            if($settingService->getSetting('security.microsoft.enabled')){
                $oauthClient = new GenericProvider([
                    'clientId'                => $settingService->getSetting('security.microsoft.client.id'),
                    'clientSecret'            => $settingService->getSetting('security.microsoft.client.secret'),
                    'redirectUri'             => $settingService->getSetting('security.microsoft.redirectUri'),
                    'urlAuthorize'            => $settingService->getSetting('security.microsoft.url.authorize'),
                    'urlAccessToken'          => $settingService->getSetting('security.microsoft.url.accessToken'),
                    'urlResourceOwnerDetails' => $settingService->getSetting('security.microsoft.url.ressource'),
                    'scopes'                  => $settingService->getSetting('security.microsoft.scopes')
                ]);
                $authUrl = $oauthClient->getAuthorizationUrl();
                $session->set('oauthState', $oauthClient->getState());

                return $this->redirect($authUrl);
            } else return $this->redirectToRoute('root');
        }

        /**
         * @Route("login/microsoft/callback.html", name="login.microsoft.callback", methods={"GET"})
         */
        public function loginMicrosoftCallback(){
        }

    }