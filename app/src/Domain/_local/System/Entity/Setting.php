<?php
    namespace App\Domain\_local\System\Entity;

    use Doctrine\ORM\Mapping as ORM;

    /**
     * @ORM\Entity(repositoryClass="App\Domain\_local\System\Repository\SettingRepository")
     * @ORM\Table(name="system_setting")
     */
    class Setting {

        /**
         * @ORM\Id()
         * @ORM\Column(type="string", unique=true)
         */
        private $setting;

        /**
         * @ORM\Column(type="text", nullable=true)
         */
        private $value;

        /**
         * @ORM\Column(type="string")
         */
        private $type;

        public function getSetting() {
            return $this->setting;
        }

        public function setSetting($setting): self {
            $this->setting = $setting;
            return $this;
        }

        public function getValue() {
            return $this->value;
        }

        public function setValue($value): self {
            $this->value = $value;
            return $this;
        }

        public function getType() {
            return $this->type;
        }

        public function setType($type): self {
            $this->type = $type;
            return $this;
        }

    }