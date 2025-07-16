<?php

namespace Handler;

use App\Handler\GalleryListHandler;
use App\Repository\GalleryRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sx\Message\Response\ResponseHelperInterface;

class GalleryListHandlerTest extends TestCase
{
    private GalleryListHandler $handler;

    private MockObject $helperMock;

    private MockObject $galleryRepositoryMock;

    private MockObject $requestMock;

    private MockObject $responseMock;

    protected function setUp(): void
    {
        $this->helperMock = $this->createMock(ResponseHelperInterface::class);
        $this->galleryRepositoryMock = $this->createMock(GalleryRepository::class);
        $this->handler = new GalleryListHandler(
            $this->helperMock,
            $this->galleryRepositoryMock,
        );
        $this->requestMock = $this->createMock(ServerRequestInterface::class);
        $this->responseMock = $this->createMock(ResponseInterface::class);
    }

    public function testHandle(): void
    {
        $data = ['data'];
        $this->galleryRepositoryMock->method('list')->willReturn($data);
        $this->helperMock->method('create')->with(200, $data)->willReturn($this->responseMock);
        $response = $this->handler->handle($this->requestMock);
        $this->assertSame($this->responseMock, $response);
    }
}
