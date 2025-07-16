<?php

namespace Handler;

use App\Handler\ImageListHandler;
use App\Repository\ImageRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sx\Message\Response\ResponseHelperInterface;

class ImageListHandlerTest extends TestCase
{
    private ImageListHandler $handler;

    private MockObject $helperMock;

    private MockObject $imageRepositoryMock;

    private MockObject $requestMock;

    private MockObject $responseMock;

    protected function setUp(): void
    {
        $this->helperMock = $this->createMock(ResponseHelperInterface::class);
        $this->imageRepositoryMock = $this->createMock(ImageRepository::class);
        $this->handler = new ImageListHandler(
            $this->helperMock,
            $this->imageRepositoryMock,
        );
        $this->requestMock = $this->createMock(ServerRequestInterface::class);
        $this->responseMock = $this->createMock(ResponseInterface::class);
    }

    public function testHandle(): void
    {
        $data = ['data'];
        $this->imageRepositoryMock
            ->expects($this->once())
            ->method('list')
            ->with(null)
            ->willReturn($data);
        $this->helperMock->method('create')->with(200, $data)->willReturn($this->responseMock);
        $response = $this->handler->handle($this->requestMock);
        $this->assertSame($this->responseMock, $response);
    }

    public function testHandleWithGallery(): void
    {
        $this->requestMock->method('getQueryParams')->willReturn(['gallery' => 42]);
        $this->imageRepositoryMock
            ->expects($this->once())
            ->method('list')
            ->with(42)
            ->willReturn([]);
        $this->helperMock->method('create')->willReturn($this->responseMock);
        $this->handler->handle($this->requestMock);
    }
}
