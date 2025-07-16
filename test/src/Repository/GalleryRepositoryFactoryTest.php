<?php

namespace Repository;

use App\Repository\GalleryRepositoryFactory;
use App\Storage\GalleryStorage;
use PHPUnit\Framework\TestCase;
use Sx\Container\Injector;

class GalleryRepositoryFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $injector = new Injector();

        $injector->set(GalleryStorage::class, $this->createMock(GalleryStorage::class));

        $factory = new GalleryRepositoryFactory();
        self::assertNotNull($factory->create($injector, [], ''));
    }
}
