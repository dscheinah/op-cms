<?php

namespace Repository;

use App\Repository\CalendarRepositoryFactory;
use App\Storage\CalendarStorage;
use PHPUnit\Framework\TestCase;
use Sx\Container\Injector;

class CalendarRepositoryFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $injector = new Injector();

        $injector->set(CalendarStorage::class, $this->createMock(CalendarStorage::class));

        $factory = new CalendarRepositoryFactory();
        self::assertNotNull($factory->create($injector, [], ''));
    }
}
