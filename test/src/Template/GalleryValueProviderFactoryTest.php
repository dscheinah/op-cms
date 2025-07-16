<?php

namespace Template;

use App\Storage\GalleryStorage;
use App\Template\GalleryValueProviderFactory;
use PHPUnit\Framework\TestCase;
use Sx\Container\Injector;

class GalleryValueProviderFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $injector = new Injector();

        $injector->set(GalleryStorage::class, $this->createMock(GalleryStorage::class));

        $factory = new GalleryValueProviderFactory();
        self::assertNotNull($factory->create($injector, [], ''));
    }
}
