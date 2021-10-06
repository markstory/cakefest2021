<?php
declare(strict_types=1);

namespace App\Test\Acceptance;

use App\Test\Factory\UserFactory;

class EditUserTest extends AcceptanceTestCase
{
    public function testSuccess()
    {
        $user = UserFactory::make(1)->persist();

        $client = $this->createClient();

        $client->get("/users/edit/{$user->id}");
        $client->waitFor('.main');
        $client->submitForm('Submit', [
            'username' => 'updated@example.com',
        ]);
        // $client->waitFor('.message.success');
        $client->waitFor('[data-testid="flash-success"]');

        $updated = $this->getTableLocator()->get('Users')->findById($user->id)->firstOrFail();
        $this->assertEquals('updated@example.com', $updated->username);
    }

    public function testDeleteSuccess()
    {
        $user = UserFactory::make(1)->persist();
        $client = $this->createClient();

        $client->get("/users/view/{$user->id}");
        $client->waitFor('.main');

        // Click the delete link and accept the confirm.
        $crawler = $client->getCrawler();
        $link = $crawler->filter('[data-testid="action-delete"]')->first();
        $link->click();
        $client->switchTo()->alert()->accept();

        $client->waitFor('[data-testid="flash-success"]');

        $this->assertEmpty($this->getTableLocator()->get('Users')->findById($user->id)->first());
    }
}
