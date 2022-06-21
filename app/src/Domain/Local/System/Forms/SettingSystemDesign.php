<?php
    namespace App\Domain\Local\System\Forms;

    use Symfony\Component\HttpFoundation\File\File;
    use Vich\UploaderBundle\Mapping\Annotation as Vich;

    /**
     * @Vich\Uploadable()
     */
    class SettingSystemDesign {

        private $icon;

        /**
         * @Vich\UploadableField(mapping="system", fileNameProperty="icon")
         */
        private $iconFile;

        private $logo;

        /**
         * @Vich\UploadableField(mapping="system", fileNameProperty="logo")
         */
        private $logoFile;

        public function getIcon() {
            return $this->icon;
        }

        public function setIcon($icon): self {
            $this->icon = $icon;
            return $this;
        }

        public function getIconFile(): ?File {
            return $this->iconFile;
        }

        public function setIconFile(?File $iconFile = null): self {
            $this->iconFile = $iconFile;
            return $this;
        }

        public function getLogo() {
            return $this->logo;
        }

        public function setLogo($logo): self {
            $this->logo = $logo;
            return $this;
        }

        public function getLogoFile(): ?File {
            return $this->logoFile;
        }

        public function setLogoFile(?File $logoFile = null): self {
            $this->logoFile = $logoFile;
            return $this;
        }

    }