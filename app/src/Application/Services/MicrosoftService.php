<?php
    namespace App\Application\Services;

    use App\Domain\Mysql\System\Entity\User;
    use Doctrine\ORM\EntityManagerInterface;
    use League\OAuth2\Client\Provider\GenericProvider;
    use Microsoft\Graph\Graph;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Session\Session;

    class MicrosoftService {

        private EntityManagerInterface $entityManager;
        private Request $request;
        private Session $session;
        private SettingService $settingService;

        private $accessToken;
        private $user;

        public function __construct(EntityManagerInterface $entityManager, Request $request, SettingService $settingService){
            $this->entityManager = $entityManager;
            $this->request = $request;
            $this->session = $this->request->getSession();
            $this->settingService = $settingService;

            $this->accessToken = $this->session->get('O365AccessToken');
        }

        private function getGraphQuery($query, $type = "GET"){
            $graph = new Graph();
            $graph->setAccessToken($this->accessToken);
            return $graph->createRequest($type, $query)->execute()->getBody();
        }

        private function getGraphUserByEmail($email){
            $graph = new Graph();
            $graph->setAccessToken($this->accessToken);
            $data = $graph->createRequest('GET', '/users/'.$email.'/')->execute()->getBody();
            return $data;
        }

        public function getAccessToken(){
            return $this->accessToken;
        }

        public function getUser(){
            return $this->user;
        }

        public function initUserAuthCode($code){
            $accessToken = $this->session->get('O365AccessToken');
            if(!$accessToken){
                $oauthClient = new GenericProvider([
                    'clientId'                => $this->settingService->getSetting('security.microsoft.client.id'),
                    'clientSecret'            => $this->settingService->getSetting('security.microsoft.client.secret'),
                    'redirectUri'             => $this->settingService->getSetting('security.microsoft.redirectUri'),
                    'urlAuthorize'            => $this->settingService->getSetting('security.microsoft.url.authorize'),
                    'urlAccessToken'          => $this->settingService->getSetting('security.microsoft.url.accessToken'),
                    'urlResourceOwnerDetails' => $this->settingService->getSetting('security.microsoft.url.ressource'),
                    'scopes'                  => $this->settingService->getSetting('security.microsoft.scopes')
                ]);
                try {
                    $this->accessToken = $oauthClient->getAccessToken('authorization_code', [
                        'code'  => $code
                    ]);
                } catch (\Exception $e){
                    throw new \Exception($e->getMessage());
                }
            }
        }

        public function syncUserByEmail($email){
            $data = $this->getGraphUserByEmail($email);
            $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $email]);

            if(!$user){
                $user = new User();
                $user->setUsername($email);
                $user->setSource("social");
            } else {

            }

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->user = $user;

            return $user;
        }

        public function syncUserMe(){
            $data = $this->getGraphQuery('/me/');
            $email = $data['mail'];
            if($email == null) $email = $data['userPrincipalName'];
            $this->syncUserByEmail($email);
        }

    }