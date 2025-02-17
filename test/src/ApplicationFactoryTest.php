<?php

use App\ApplicationFactory;
use PHPUnit\Framework\TestCase;
use Sx\Container\Injector;
use Sx\Server\MiddlewareHandlerInterface;

class ApplicationFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $injector = new Injector();
        $injector->set(MiddlewareHandlerInterface::class, $this->createMock(MiddlewareHandlerInterface::class));
        $factory = new ApplicationFactory();
        self::assertNotNull($factory->create($injector, [], ''));
    }
}
