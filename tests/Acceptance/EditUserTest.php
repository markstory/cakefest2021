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
        $client->waitFor('.message.success');

        $updated = $this->getTableLocator()->get('Users')->findById($user->id)->firstOrFail();
        $this->assertEquals('updated@example.com', $updated->username);
    }
}
