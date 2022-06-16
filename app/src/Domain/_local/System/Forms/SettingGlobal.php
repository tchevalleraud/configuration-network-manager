<?php
    namespace App\Domain\_local\System\Forms;

    use App\Application\Services\SettingService;

    class SettingGlobal {

        private $security_session_idle;

        public function __construct(SettingService $settingService){
            $this->setSecuritySessionIdle($settingService->getSetting('security.session.idle'));
        }

        public function getSecuritySessionIdle(){
            return $this->security_session_idle;
        }

        public function setSecuritySessionIdle($security_session_idle): self {
            $this->security_session_idle = $security_session_idle;
            return $this;
        }

    }
