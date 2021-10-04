<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Service\CalendarService;
use App\Test\Factory\CalendarItemFactory;
use Cake\TestSuite\ContainerStubTrait;
use Cake\TestSuite\HttpClientTrait;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\I18n\FrozenTime;

class CalendarsControllerTest extends TestCase
{
    use ContainerStubTrait;
    use HttpClientTrait;
    use IntegrationTestTrait;

    public $fixtures = [
        'app.Users',
        'app.CalendarItems',
    ];

    public function testIndexWithClientMock()
    {
        $response = $this->newClientResponse(200, [], '[{"id":1}, {"id":2}]');
        $this->mockClientGet('https://calendar.google.com/api/1', $response);

        $this->get('/calendars');

        $this->assertResponseOk();
        $this->assertResponseContains('"id":1');
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

        $this->assertResponseOk();
        $this->assertResponseContains('"id":9');
    }

    public function testGetLocal()
    {
        CalendarItemFactory::make(2)->persist();

        $service = $this->createApp()->getContainer()->get(CalendarService::class);
        $result = $service->getLocal();

        $this->assertCount(2, $result);
        $this->assertInstanceOf(FrozenTime::class, $result[0]->start_time);
        $this->assertInstanceOf(FrozenTime::class, $result[1]->start_time);
        $this->assertEquals(1, $result[0]->user_id);
        $this->assertEquals(1, $result[1]->user_id);
    }
}
