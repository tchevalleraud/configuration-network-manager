<?php
    namespace App\Tests\WebTestCase\FrontOffice;

    use App\Tests\WebTestCase;
    use Symfony\Component\HttpFoundation\Response;

    class DashboardTest extends WebTestCase {
        /**
        public function test_EN_Index(){
            $crawler = $this->client->request('GET', '/en/dashboard.html');
            $this->assertResponseStatusCodeSame(Response::HTTP_OK);
            $this->assertEquals('configuration network manager', $crawler->filter('title')->text());
        }

        public function test_FR_Index(){
            $crawler = $this->client->request('GET', '/fr/dashboard.html');
            $this->assertResponseStatusCodeSame(Response::HTTP_OK);
            $this->assertEquals('configuration network manager', $crawler->filter('title')->text());
        }
         * */

    }