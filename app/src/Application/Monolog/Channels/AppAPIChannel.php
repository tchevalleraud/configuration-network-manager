<?php
    namespace App\Application\Monolog\Channels;

    use Psr\Log\LoggerInterface;

    class AppAPIChannel {

        protected $apiLogger;

        public function __construct(LoggerInterface $apiLogger){
            $this->apiLogger = $apiLogger;
            return $this->apiLogger;
        }

        public function __call($name, $arguments){
            $this->apiLogger->{$name}($arguments[0]);
        }

    }