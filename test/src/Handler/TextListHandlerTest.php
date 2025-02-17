<?php

namespace Handler;

use App\Handler\TextListHandler;
use App\Repository\TextRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sx\Message\Response\ResponseHelperInterface;

class TextListHandlerTest extends TestCase
{
    private TextListHandler $handler;

    private MockObject $helperMock;

    private MockObject $textRepositoryMock;

    private MockObject $requestMock;

    private MockObject $responseMock;

    protected function setUp(): void
    {
        $this->helperMock = $this->createMock(ResponseHelperInterface::class);
        $this->textRepositoryMock = $this->createMock(TextRepository::class);
        $this->handler = new TextListHandler(
            $this->helperMock,
            $this->textRepositoryMock,
        );
        $this->requestMock = $this->createMock(ServerRequestInterface::class);
        $this->responseMock = $this->createMock(ResponseInterface::class);
    }

    public function testHandle(): void
    {
        $data = ['data'];
        $this->textRepositoryMock->method('list')->willReturn($data);
        $this->helperMock->method('create')->with(200, $data)->willReturn($this->responseMock);
        $response = $this->handler->handle($this->requestMock);
        $this->assertSame($this->responseMock, $response);
    }
}
