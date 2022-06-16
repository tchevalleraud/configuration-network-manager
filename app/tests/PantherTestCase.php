<?php
    namespace App\Tests;

    use Symfony\Component\Panther\Client;

    class PantherTestCase extends \Symfony\Component\Panther\PantherTestCase {

        protected Client $client;

        protected function setUp(): void {
            parent::setUp();

            $this->client = static::createPantherClient([
                'external_base_uri' => self::getContainer()->getParameter('APP_URI')
            ]);

            parent::setUp();
        }

    }