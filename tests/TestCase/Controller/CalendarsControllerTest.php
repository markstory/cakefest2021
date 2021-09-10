<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\HttpClientTrait;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class CalendarsControllerTest extends TestCase
{
    use HttpClientTrait;
    use IntegrationTestTrait;

    public function testIndex()
    {
        $this->get('/calendars');

        $this->assertResponseOk();
        debug(substr($this->_response->getBody() . '', 0, 300));
    }
}
