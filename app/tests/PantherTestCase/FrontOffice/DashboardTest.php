<?php
    namespace App\Tests\PantherTestCase\FrontOffice;

    use App\Tests\PantherTestCase;

    class DashboardTest extends PantherTestCase {

        public function test_EN_Index(){
            $this->client->request('GET', '/en/dashboard.html');
            $this->assertPageTitleContains('configuration network manager');
            $this->assertSelectorTextContains('h1', 'FrontOffice/Dashboard:index');
        }

        public function test_FR_Index(){
            $this->client->request('GET', '/fr/dashboard.html');
            $this->assertPageTitleContains('configuration network manager');
            $this->assertSelectorTextContains('h1', 'FrontOffice/Dashboard:index');
        }

    }