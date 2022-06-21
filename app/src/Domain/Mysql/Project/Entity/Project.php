<?php
    namespace App\Domain\Mysql\Project\Entity;

    use Doctrine\ORM\Mapping as ORM;
    use Ramsey\Uuid\Doctrine\UuidGenerator;
    use Symfony\Component\HttpFoundation\File\File;
    use Vich\UploaderBundle\Mapping\Annotation as Vich;

    /**
     * @ORM\Entity(repositoryClass="App\Domain\Mysql\Project\Repository\ProjectRepository")
     * @ORM\Table(name="project")
     */
    class Project {

        /**
         * @ORM\Id()
         * @ORM\GeneratedValue(strategy="CUSTOM")
         * @ORM\CustomIdGenerator(class=UuidGenerator::class)
         * @ORM\Column(type="string", unique=true)
         */
        private $id;

        /**
         * @ORM\Column(type="string", length=180)
         */
        private $name;

        /**
         * @ORM\Column(type="text", nullable=true)
         */
        private $description;

        /**
         * @ORM\Column(type="string", nullable=true)
         */
        private $sourceModel;

        /**
         * @ORM\Column(type="string", nullable=true)
         */
        private $sourceConfig;

        /**
         * @ORM\Column(type="string")
         */
        private $destinationModel;

        /**
         * @ORM\Column(type="datetime")
         */
        private $createdDate;

        private $sourceConfigFile;

        public function __construct(){
            $this->createdDate = new \DateTime();
        }

        public function getId() {
            return $this->id;
        }

        public function setId($id): self {
            $this->id = $id;
            return $this;
        }

        public function getName() {
            return $this->name;
        }

        public function setName($name): self {
            $this->name = $name;
            return $this;
        }

        public function getDescription() {
            return $this->description;
        }

        public function setDescription($description): self {
            $this->description = $description;
            return $this;
        }

        public function getSourceModel() {
            return $this->sourceModel;
        }

        public function setSourceModel($sourceModel): self {
            $this->sourceModel = $sourceModel;
            return $this;
        }

        public function getSourceConfig() {
            return $this->sourceConfig;
        }

        public function setSourceConfig($sourceConfig): self {
            $this->sourceConfig = $sourceConfig;
            return $this;
        }

        public function getDestinationModel() {
            return $this->destinationModel;
        }

        public function setDestinationModel($destinationModel): self {
            $this->destinationModel = $destinationModel;
            return $this;
        }

        public function getCreatedDate() {
            return $this->createdDate;
        }

        public function setCreatedDate($createdDate): self {
            $this->createdDate = $createdDate;
            return $this;
        }
        
        public function getSourceConfigFile(): ?File {
            return $this->sourceConfigFile;
        }

        public function setSourceConfigFile(?File $sourceConfigFile = null): self {
            $this->sourceConfigFile = $sourceConfigFile;
            return $this;
        }

    }