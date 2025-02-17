<?php

namespace Template;

use App\Storage\PageStorage;
use App\Template\PageValueProviderFactory;
use PHPUnit\Framework\TestCase;
use Sx\Container\Injector;

class PageValueProviderFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $injector = new Injector();

        $injector->set(PageStorage::class, $this->createMock(PageStorage::class));

        $factory = new PageValueProviderFactory();
        self::assertNotNull($factory->create($injector, [], ''));
    }
}
