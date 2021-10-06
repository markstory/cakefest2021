<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'username' => 'test@example.com',
                'password' => 'Lorem ipsum dolor sit amet',
                'created' => '2021-09-12 02:27:51',
                'modified' => '2021-09-12 02:27:51',
            ],
        ];
        parent::init();
    }
}
