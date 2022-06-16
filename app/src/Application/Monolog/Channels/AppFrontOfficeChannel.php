<?php
    namespace App\Application\Monolog\Channels;

    use Psr\Log\LoggerInterface;

    class AppFrontOfficeChannel {

        protected $frontofficeLogger;

        public function __construct(LoggerInterface $frontofficeLogger){
            $this->frontofficeLogger = $frontofficeLogger;
            return $this->frontofficeLogger;
        }

        public function __call($name, $arguments){
            $this->frontofficeLogger->{$name}($arguments[0]);
        }

    }