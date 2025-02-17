<?php

namespace Handler;

use App\Handler\TextRemoveHandler;
use App\Repository\TextRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sx\Message\Response\ResponseHelperInterface;

class TextRemoveHandlerTest extends TestCase
{
    private TextRemoveHandler $handler;

    private MockObject $helperMock;

    private MockObject $textRepositoryMock;

    private MockObject $requestMock;

    private MockObject $responseMock;

    protected function setUp(): void
    {
        $this->helperMock = $this->createMock(ResponseHelperInterface::class);
        $this->textRepositoryMock = $this->createMock(TextRepository::class);
        $this->handler = new TextRemoveHandler(
            $this->helperMock,
            $this->textRepositoryMock,
        );
        $this->requestMock = $this->createMock(ServerRequestInterface::class);
        $this->responseMock = $this->createMock(ResponseInterface::class);
    }

    public function testHandle(): void
    {
        $id = 42;
        $this->requestMock->method('getQueryParams')->willReturn(['id' => $id]);
        $this->textRepositoryMock->expects($this->once())->method('remove');
        $this->helperMock->method('create')->with(204)->willReturn($this->responseMock);
        $response = $this->handler->handle($this->requestMock);
        $this->assertSame($this->responseMock, $response);
    }
}
