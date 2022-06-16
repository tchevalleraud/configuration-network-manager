<?php
    namespace App\Application\Command\System;

    use App\Domain\_local\System\Entity\Setting;
    use App\Domain\_mysql\System\Entity\User;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use Symfony\Component\HttpKernel\KernelInterface;
    use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

    class InitCommand extends Command {

        protected static $defaultName = "app:system:init";

        private EntityManagerInterface $em;
        private EntityManagerInterface $emLocal;
        private KernelInterface $kernel;
        private UserPasswordHasherInterface $passwordHasher;

        public function __construct(KernelInterface $kernel, UserPasswordHasherInterface $passwordHasher) {
            parent::__construct();

            $this->kernel = $kernel;
            $this->passwordHasher = $passwordHasher;

            $this->em = $this->kernel->getContainer()->get('doctrine')->getManager('mysql');
            $this->emLocal = $this->kernel->getContainer()->get('doctrine')->getManager('local');
        }

        public function execute(InputInterface $input, OutputInterface $output) {
            $user = $this->em->getRepository(User::class)->findOneBy(['username' => 'root', 'source' => 'local']);
            if(!$user){
                $user = new User();
                $user->setUsername("root");
                $user->setPassword($this->passwordHasher->hashPassword($user, "password"));

                $this->em->persist($user);
                $this->em->flush();
            }

            $this->checkSetting("security.session.idle", 3600, "integer");

            $this->checkSetting("security.ldap.connections", json_encode([]), "array");
            $this->checkSetting("security.ldap.authentication.username");
            $this->checkSetting("security.ldap.authentication.password");
            $this->checkSetting("security.ldap.search.user");
            $this->checkSetting("security.ldap.schema.user.object");
            $this->checkSetting("security.ldap.schema.user.search");
            $this->checkSetting("security.ldap.enabled", false, "boolean");

            $this->checkSetting("security.facebook.enabled", false, "boolean");

            $this->checkSetting("security.github.enabled", false, "boolean");

            $this->checkSetting("security.google.enabled", false, "boolean");

            $this->checkSetting("security.instagram.enabled", false, "boolean");

            $this->checkSetting("security.linkedin.enabled", false, "boolean");

            $this->checkSetting("security.microsoft.client.id", false, "boolean");
            $this->checkSetting("security.microsoft.client.secret");
            $this->checkSetting("security.microsoft.redirectUri");
            $this->checkSetting("security.microsoft.url.authorize", "https://login.microsoftonline.com/common/oauth2/v2.0/authorize");
            $this->checkSetting("security.microsoft.url.accessToken", "https://login.microsoftonline.com/common/oauth2/v2.0/token");
            $this->checkSetting("security.microsoft.url.ressource");
            $this->checkSetting("security.microsoft.scopes", "openid profile User.Read User.ReadBasic.All");
            $this->checkSetting("security.microsoft.enabled", false, "boolean");

            return Command::SUCCESS;
        }

        private function checkSetting($key, $value = "NULL", $type = "string"){
            $setting = $this->emLocal->getRepository(Setting::class)->findOneBy(['setting' => $key]);
            if(!$setting){
                $setting = new Setting();
                $setting->setSetting($key);
                $setting->setValue($value);
                $setting->setType($type);

                $this->emLocal->persist($setting);
                $this->emLocal->flush();
            }
        }

    }