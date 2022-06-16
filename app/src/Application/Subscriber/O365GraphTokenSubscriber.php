<?php
    namespace App\Application\Subscriber;

    use Symfony\Component\HttpFoundation\RequestStack;
    use Symfony\Component\HttpFoundation\Session\Session;
    use Symfony\Component\HttpKernel\Event\RequestEvent;

    class O365GraphTokenSubscriber {

        private RequestStack $requestStack;
        private Session $session;

        public function __construct(RequestStack $request){
            $this->requestStack = $request;
        }

        public function onKernelRequest(RequestEvent $event){
            $this->session = $this->requestStack->getSession();

            $now = new \DateTime();
            $accessToken = $this->session->get('O365AccessToken');

            if($accessToken){
                if($now->format('U') > $accessToken->getExpires()) {
                    $this->session->remove('O365AccessToken');
                    $this->session->remove('_security_main');
                }
            }
        }

    }