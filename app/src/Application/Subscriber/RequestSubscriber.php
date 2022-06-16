<?php
    namespace App\Application\Subscriber;

    use App\Application\Monolog\LoggerManager;
    use Symfony\Component\HttpKernel\Event\RequestEvent;
    use Symfony\Contracts\Translation\TranslatorInterface;

    class RequestSubscriber {

        protected $loggerManager;
        protected $translator;

        public function __construct(LoggerManager $loggerManager, TranslatorInterface $translator){
            $this->loggerManager = $loggerManager;
            $this->translator = $translator;
        }

        public function onKernelRequest(RequestEvent $event){
            $route      = $event->getRequest()->attributes->get('_route');
            $ip         = $event->getRequest()->getMethod();
            $routeUrl   = $event->getRequest()->getPathInfo();
            $status     = $event->getRequest()->server->get('REDIRECT_STATUS');

            $msg = $ip."/".$status." - \"".$routeUrl."\" (".$route.")";

            if(preg_match("#^api.#", $route)) $this->loggerManager->appAPIChannel()->debug($msg);
            if(preg_match("#^frontoffice.#", $route)) $this->loggerManager->appFrontOfficeChannel()->debug($msg);
        }

    }