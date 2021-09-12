<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * CalendarItemFactory
 *
 * @method \App\Model\Entity\CalendarItem getEntity()
 * @method \App\Model\Entity\CalendarItem[] getEntities()
 * @method \App\Model\Entity\CalendarItem|\App\Model\Entity\CalendarItem[] persist()
 * @static \App\Model\Entity\CalendarItem get(mixed $primaryKey, array $options)
 */
class CalendarItemFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'CalendarItems';
    }

    /**
     * Defines the factory's default values. This is useful for
     * not nullable fields. You may use methods of the present factory here too.
     *
     * @return void
     */
    protected function setDefaultTemplate(): void
    {
        $this->setDefaultData(function (Generator $faker) {
            $start = $faker->dateTimeBetween('now', '+15 days');
            $endTime = $start->modify('30 minutes');

            return [
                'title' => $faker->sentence(),
                'description' => $faker->sentences(2),
                'start_time' => $start,
                'end_time' => $endTime,
            ];
        });
    }
}
