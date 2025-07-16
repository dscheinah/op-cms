<?php

namespace Handler;

use App\Handler\ImageHandlerFactory;
use App\Repository\ImageRepository;
use PHPUnit\Framework\TestCase;
use Psr\Http\Server\RequestHandlerInterface;
use Sx\Container\Injector;
use Sx\Message\Response\ResponseHelperInterface;

class ImageHandlerFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $injectorMock = $this->createMock(Injector::class);
        $handlerMock = $this->createMock(RequestHandlerInterface::class);

        $injectorMock->expects($this->exactly(2))->method('get')->with(
            $this->logicalOr(
                ResponseHelperInterface::class,
                ImageRepository::class,
            )
        );

        $factory = new ImageHandlerFactory();
        self::assertNotNull($factory->create($injectorMock, [], get_class($handlerMock)));
    }
}
