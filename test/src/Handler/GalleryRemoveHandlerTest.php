<?php

namespace Handler;

use App\Handler\GalleryRemoveHandler;
use App\Repository\GalleryRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sx\Message\Response\ResponseHelperInterface;

class GalleryRemoveHandlerTest extends TestCase
{
    private GalleryRemoveHandler $handler;

    private MockObject $helperMock;

    private MockObject $galleryRepositoryMock;

    private MockObject $requestMock;

    private MockObject $responseMock;

    protected function setUp(): void
    {
        $this->helperMock = $this->createMock(ResponseHelperInterface::class);
        $this->galleryRepositoryMock = $this->createMock(GalleryRepository::class);
        $this->handler = new GalleryRemoveHandler(
            $this->helperMock,
            $this->galleryRepositoryMock,
        );
        $this->requestMock = $this->createMock(ServerRequestInterface::class);
        $this->responseMock = $this->createMock(ResponseInterface::class);
    }

    public function testHandle(): void
    {
        $id = 42;
        $this->requestMock->method('getQueryParams')->willReturn(['id' => $id]);
        $this->galleryRepositoryMock->expects($this->once())->method('remove');
        $this->helperMock->method('create')->with(204)->willReturn($this->responseMock);
        $response = $this->handler->handle($this->requestMock);
        $this->assertSame($this->responseMock, $response);
    }
}
