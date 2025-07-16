<?php

namespace Template;

use App\Storage\ImageStorage;
use App\Template\ImageValueProviderFactory;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Sx\Container\Injector;

class ImageValueProviderFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $injector = new Injector();

        $injector->set(ImageStorage::class, $this->createMock(ImageStorage::class));

        $factory = new ImageValueProviderFactory();

        $provider = $factory->create($injector, ['image' => ['source' => '/source//']], '');
        $reflection = new ReflectionClass($provider);
        self::assertEquals('/source', $reflection->getProperty('directory')->getValue($provider));
    }
}
