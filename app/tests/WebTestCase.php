<?php
    namespace App\Tests;

    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\KernelBrowser;

    class WebTestCase extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase {

        protected KernelBrowser $client;
        protected EntityManagerInterface $em;

        protected function setUp(): void {
            parent::setUp();

            $this->client = self::createClient();
            $this->em = self::getContainer()->get(EntityManagerInterface::class);
            $this->em->getConnection()->getConfiguration()->setSQLLogger(null);

            parent::setUp();
        }

    }