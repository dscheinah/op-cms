<?php

namespace Repository;

use App\Repository\TextRepositoryFactory;
use App\Storage\TextStorage;
use PHPUnit\Framework\TestCase;
use Sx\Container\Injector;

class TextRepositoryFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $injector = new Injector();

        $injector->set(TextStorage::class, $this->createMock(TextStorage::class));

        $factory = new TextRepositoryFactory();
        self::assertNotNull($factory->create($injector, [], ''));
    }
}
