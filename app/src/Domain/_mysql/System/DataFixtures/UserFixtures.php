<?php
    namespace App\Domain\_mysql\System\DataFixtures;

    use App\Domain\_mysql\System\Entity\User;
    use Doctrine\Bundle\FixturesBundle\Fixture;
    use Doctrine\Persistence\ObjectManager;
    use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

    class UserFixtures extends Fixture {

        private $passwordHasher;

        public function __construct(UserPasswordHasherInterface $passwordHasher){
            $this->passwordHasher = $passwordHasher;
        }

        public function load(ObjectManager $manager) {
            $user = new User();
            $user->setEmail("admin@pwsb.fr");
            $user->setPassword($this->passwordHasher->hashPassword($user, "pwsb"));
            $user->setApiToken(implode('', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6)));

            $manager->persist($user);
            $manager->flush();
        }

    }