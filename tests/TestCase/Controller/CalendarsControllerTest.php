<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Service\CalendarService;
use Cake\TestSuite\ContainerStubTrait;
use Cake\TestSuite\HttpClientTrait;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class CalendarsControllerTest extends TestCase
{
    use ContainerStubTrait;
    use HttpClientTrait;
    use IntegrationTestTrait;

    public function testIndexWithClientMock()
    {
        $response = $this->newClientResponse(200, [], '[{"id":1}, {"id":2}]');
        $this->mockClientGet('https://calendar.google.com/api/1', $response);

        $this->get('/calendars');

        $this->assertResponseOk();
        $this->assertResponseContains('"id":1');
        debug(substr($this->_response->getBody() . '', 0, 300));
    }

    public function testIndexWithServiceMock()
    {
        $this->mockService(CalendarService::class, function () {
            $mock = $this->getMockBuilder(CalendarService::class)
                ->disableOriginalConstructor()
                ->getMock();
            $mock->expects($this->once())
                ->method('getCalendarList')
                ->will($this->returnValue([['id' => 9], ['id' => 10]]));

            return $mock;
        });
        $this->get('/calendars');

        debug(substr($this->_response->getBody() . '', 0, 300));
        $this->assertResponseOk();
        $this->assertResponseContains('"id":9');
    }
}
