<?php

namespace Template;

use App\Storage\CalendarStorage;
use App\Template\CalendarValueProviderFactory;
use PHPUnit\Framework\TestCase;
use Sx\Container\Injector;

class CalendarValueProviderFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $injector = new Injector();

        $injector->set(CalendarStorage::class, $this->createMock(CalendarStorage::class));

        $factory = new CalendarValueProviderFactory();
        self::assertNotNull($factory->create($injector, [], ''));
    }
}
