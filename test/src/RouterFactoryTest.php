<?php

use App\RouterFactory;
use PHPUnit\Framework\TestCase;
use Sx\Container\Injector;
use Sx\Server\MiddlewareHandlerInterface;

class RouterFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $injector = new Injector();
        $injector->set(MiddlewareHandlerInterface::class, $this->createMock(MiddlewareHandlerInterface::class));
        $factory = new RouterFactory();
        self::assertNotNull($factory->create($injector, [], ''));
    }
}
