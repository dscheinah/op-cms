<?php

namespace Handler;

use App\Handler\TextLoadHandler;
use App\Repository\TextRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sx\Message\Response\ResponseHelperInterface;

class TextLoadHandlerTest extends TestCase
{
    private TextLoadHandler $handler;

    private MockObject $helperMock;

    private MockObject $textRepositoryMock;

    private MockObject $requestMock;

    private MockObject $responseMock;

    protected function setUp(): void
    {
        $this->helperMock = $this->createMock(ResponseHelperInterface::class);
        $this->textRepositoryMock = $this->createMock(TextRepository::class);
        $this->handler = new TextLoadHandler(
            $this->helperMock,
            $this->textRepositoryMock,
        );
        $this->requestMock = $this->createMock(ServerRequestInterface::class);
        $this->responseMock = $this->createMock(ResponseInterface::class);
    }

    public function testHandle(): void
    {
        $id = 42;
        $data = ['data'];
        $this->requestMock->method('getQueryParams')->willReturn(['id' => $id]);
        $this->textRepositoryMock->method('load')->with($id)->willReturn($data);
        $this->helperMock->method('create')->with(200, $data)->willReturn($this->responseMock);
        $response = $this->handler->handle($this->requestMock);
        $this->assertSame($this->responseMock, $response);
    }

    public function testHandleNotFound(): void
    {
        $id = 42;
        $this->requestMock->method('getQueryParams')->willReturn(['id' => $id]);
        $this->textRepositoryMock->method('load')->with($id)->willReturn(null);
        $this->helperMock->method('create')->with(404)->willReturn($this->responseMock);
        $response = $this->handler->handle($this->requestMock);
        $this->assertSame($this->responseMock, $response);
    }
}
