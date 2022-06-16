<?php
    namespace App\Application\Monolog;

    use App\Application\Monolog\Channels\AppAPIChannel;
    use App\Application\Monolog\Channels\AppFrontOfficeChannel;

    class LoggerManager {

        protected $appAPIChannel;
        protected $appFrontOfficeChannel;

        public function __construct(
            AppAPIChannel $appAPIChannel,
            AppFrontOfficeChannel $appFrontOfficeChannel
        ){
            $this->appAPIChannel = $appAPIChannel;
            $this->appFrontOfficeChannel = $appFrontOfficeChannel;
        }

        public function appAPIChannel(){
            return $this->appAPIChannel;
        }

        public function appFrontOfficeChannel(){
            return $this->appFrontOfficeChannel;
        }

    }