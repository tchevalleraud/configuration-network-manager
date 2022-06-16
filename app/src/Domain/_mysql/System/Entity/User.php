<?php
    namespace App\Domain\_mysql\System\Entity;

    use Doctrine\ORM\Mapping as ORM;
    use Ramsey\Uuid\Doctrine\UuidGenerator;
    use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
    use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
    use Symfony\Component\Security\Core\User\UserInterface;

    /**
     * @ORM\Entity(repositoryClass="App\Domain\_mysql\System\Repository\UserRepository")
     * @ORM\Table(name="system_user")
     * @UniqueEntity("email")
     */
    class User implements UserInterface, PasswordAuthenticatedUserInterface {

        /**
         * @ORM\Id()
         * @ORM\GeneratedValue(strategy="CUSTOM")
         * @ORM\CustomIdGenerator(class=UuidGenerator::class)
         * @ORM\Column(type="string", unique=true)
         */
        private $id;

        /**
         * @ORM\Column(type="string", length=180, unique=true)
         */
        private $username;

        /**
         * @ORM\Column(type="string", nullable=true)
         */
        private $password;

        /**
         * @ORM\Column(type="string")
         */
        private $apiToken;

        /**
         * @ORM\Column(type="json")
         */
        private $roles = [];

        /**
         * @ORM\Column(type="string")
         */
        private $source;

        public function __construct() {
            $this->setApiToken(implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6)));
            $this->setSource("local");
        }

        public function getId(): ?string {
            return $this->id;
        }

        public function setId($id): self {
            $this->id = $id;
            return $this;
        }

        public function getUsername() {
            return $this->username;
        }

        public function setUsername($username): self {
            $this->username = $username;
            return $this;
        }

        public function getUserIdentifier(): string {
            return $this->getUsername();
        }

        public function getPassword(): ?string {
            return $this->password;
        }

        public function setPassword($password): self {
            $this->password = $password;
            return $this;
        }

        public function getSalt(): ?string {
            return null;
        }

        public function getApiToken(): ?string {
            return $this->apiToken;
        }

        public function setApiToken($apiToken): self {
            $this->apiToken = $apiToken;
            return $this;
        }

        public function getRoles(): array {
            $roles = $this->roles;
            $roles[] = 'ROLE_USER';

            return array_unique($roles);
        }

        public function setRoles(array $roles): self {
            $this->roles = $roles;
            return $this;
        }

        public function getSource() {
            return $this->source;
        }

        public function setSource($source): self {
            $this->source = $source;
            return $this;
        }

        public function eraseCredentials() {
            // TODO: Implement eraseCredentials() method.
        }

    }