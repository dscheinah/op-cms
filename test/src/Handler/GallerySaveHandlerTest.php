<?php

namespace Handler;

use App\Handler\GallerySaveHandler;
use App\Repository\GalleryRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sx\Message\Response\ResponseHelperInterface;

class GallerySaveHandlerTest extends TestCase
{
    private GallerySaveHandler $handler;

    private MockObject $helperMock;

    private MockObject $galleryRepositoryMock;

    private MockObject $requestMock;

    private MockObject $responseMock;

    protected function setUp(): void
    {
        $this->helperMock = $this->createMock(ResponseHelperInterface::class);
        $this->galleryRepositoryMock = $this->createMock(GalleryRepository::class);
        $this->handler = new GallerySaveHandler(
            $this->helperMock,
            $this->galleryRepositoryMock,
        );
        $this->requestMock = $this->createMock(ServerRequestInterface::class);
        $this->responseMock = $this->createMock(ResponseInterface::class);
    }

    public function testHandle(): void
    {
        $body = ['body'];
        $this->requestMock->method('getParsedBody')->willReturn($body);
        $this->galleryRepositoryMock->expects($this->once())->method('save')->with($body);
        $this->helperMock->method('create')->with(204)->willReturn($this->responseMock);
        $response = $this->handler->handle($this->requestMock);
        self::assertSame($this->responseMock, $response);
    }
}
