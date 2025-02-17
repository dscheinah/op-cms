<?php

namespace Handler;

use App\Handler\TextSaveHandler;
use App\Repository\TextRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sx\Message\Response\ResponseHelperInterface;

class TextSaveHandlerTest extends TestCase
{
    private TextSaveHandler $handler;

    private MockObject $helperMock;

    private MockObject $textRepositoryMock;

    private MockObject $requestMock;

    private MockObject $responseMock;

    protected function setUp(): void
    {
        $this->helperMock = $this->createMock(ResponseHelperInterface::class);
        $this->textRepositoryMock = $this->createMock(TextRepository::class);
        $this->handler = new TextSaveHandler(
            $this->helperMock,
            $this->textRepositoryMock,
        );
        $this->requestMock = $this->createMock(ServerRequestInterface::class);
        $this->responseMock = $this->createMock(ResponseInterface::class);
    }

    public function testHandle(): void
    {
        $body = ['body'];
        $this->requestMock->method('getParsedBody')->willReturn($body);
        $this->textRepositoryMock->expects($this->once())->method('save')->with($body);
        $this->helperMock->method('create')->with(204)->willReturn($this->responseMock);
        $response = $this->handler->handle($this->requestMock);
        self::assertSame($this->responseMock, $response);
    }
}
