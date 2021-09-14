<?php
declare(strict_types=1);

namespace App\Test\Acceptance;

use Cake\TestSuite\TestCase;
use Facebook\WebDriver\WebDriverDimension;
use Symfony\Component\Panther\PantherTestCaseTrait;
use Symfony\Component\Panther\Client as PantherClient;

abstract class AcceptanceTestCase extends TestCase
{
    use PantherTestCaseTrait;

    public const CHROME = 'chrome';
    public const FIREFOX = 'firefox';

    protected $fixtures = [
        'app.Users',
        'app.CalendarItems',
    ];

    /**
     * @var null|\Symfony\Component\Panther\Client
     */
    protected $client;

    protected static $cookieJar;

    /**
     * @after
     */
    public function acceptanceCleanup()
    {
        $this->client = null;
    }

    /**
     * Create a new panther client for interacting with the browser.
     */
    protected function createClient(): PantherClient
    {
        $client = static::createPantherClient([
            'browser' => static::FIREFOX,
        ], [], [
            'cookieJar' => static::$cookieJar,
        ]);
        $client->manage()->window()->setSize(new WebDriverDimension(1200, 1024));

        return $client;
    }

    public function login()
    {
        if (empty(static::$cookieJar)) {
            $this->client = $this->createClient();
            $this->client->get('/login');
            $this->client->waitFor('input[name="password"]');

            $this->client->submitForm('Login', [
                'email' => 'mark@example.com',
                'password' => 'password123',
            ]);
            static::$cookieJar = $this->client->getCookieJar();
        }

        $this->client = $this->createClient();
    }

    protected function clickWithMouse(string $selector)
    {
        $mouse = $this->client->getMouse();
        $mouse->mouseDownTo($selector)
            ->mouseUpTo($selector);
    }
}
