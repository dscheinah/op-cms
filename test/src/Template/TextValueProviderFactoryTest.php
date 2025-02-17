<?php

namespace Template;

use App\Storage\TextStorage;
use App\Template\TextValueProviderFactory;
use PHPUnit\Framework\TestCase;
use Sx\Container\Injector;

class TextValueProviderFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $injector = new Injector();

        $injector->set(TextStorage::class, $this->createMock(TextStorage::class));

        $factory = new TextValueProviderFactory();
        self::assertNotNull($factory->create($injector, [], ''));
    }
}
