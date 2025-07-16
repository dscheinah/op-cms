<?php

namespace Repository;

use App\Repository\ImageRepositoryFactory;
use App\Storage\ImageStorage;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Sx\Container\Injector;

class ImageRepositoryFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $injector = new Injector();

        $injector->set(ImageStorage::class, $this->createMock(ImageStorage::class));

        $factory = new ImageRepositoryFactory();

        $repository = $factory->create($injector, ['image' => ['source' => '/source//', 'cache' => '/cache//']], '');
        $reflection = new ReflectionClass($repository);
        self::assertEquals('/source', $reflection->getProperty('directory')->getValue($repository));
        self::assertEquals('/cache', $reflection->getProperty('cache')->getValue($repository));
    }
}
