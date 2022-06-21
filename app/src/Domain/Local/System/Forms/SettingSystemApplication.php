<?php
    namespace App\Domain\Local\System\Forms;

    use App\Application\Services\SettingService;

    class SettingSystemApplication {

        private $system_app_name;

        public function __construct(SettingService $settingService){
            $this->setSystemAppName($settingService->getSetting("system.app.name"));
        }

        public function getSystemAppName() {
            return $this->system_app_name;
        }

        public function setSystemAppName($system_app_name): self {
            $this->system_app_name = $system_app_name;
            return $this;
        }

    }