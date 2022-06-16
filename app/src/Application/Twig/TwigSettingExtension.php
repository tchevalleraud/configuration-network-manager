<?php
    namespace App\Application\Twig;

    use App\Application\Services\SettingService;
    use Twig\Extension\AbstractExtension;
    use Twig\TwigFunction;

    class TwigSettingExtension extends AbstractExtension {

        private SettingService $settingService;

        public function __construct(SettingService $settingService){
            $this->settingService =$settingService;
        }

        public function getFunctions() {
            return [
                new TwigFunction('setting', [$this, 'getSetting'])
            ];
        }

        public function getSetting($name){
            $s = $this->settingService->getSetting($name);
            if($s !== null) return $s;
            else throw new \Exception("Setting not exist");
        }

    }