<?php
    namespace App\Domain\Local\System\Forms;

    class SettingLdapConnection {

        private $ip;

        private $encryption;

        public function __construct($server = null){
            if($server !== null){
                $this->setIp($server['ip']);
                $this->setEncryption($server['encryption']);
            }
        }

        public function getIp() {
            return $this->ip;
        }

        public function setIp($ip): self {
            $this->ip = $ip;
            return $this;
        }

        public function getEncryption() {
            return $this->encryption;
        }

        public function setEncryption($encryption): self {
            $this->encryption = $encryption;
            return $this;
        }

    }