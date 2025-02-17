<?php

namespace Handler;

use App\Handler\PageSaveHandler;
use App\Repository\PageRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sx\Message\Response\ResponseHelperInterface;

class PageSaveHandlerTest extends TestCase
{
    private PageSaveHandler $handler;

    private MockObject $helperMock;

    private MockObject $pageRepositoryMock;

    private MockObject $requestMock;

    private MockObject $responseMock;

    protected function setUp(): void
    {
        $this->helperMock = $this->createMock(ResponseHelperInterface::class);
        $this->pageRepositoryMock = $this->createMock(PageRepository::class);
        $this->handler = new PageSaveHandler(
            $this->helperMock,
            $this->pageRepositoryMock,
        );
        $this->requestMock = $this->createMock(ServerRequestInterface::class);
        $this->responseMock = $this->createMock(ResponseInterface::class);
    }

    public function testHandle(): void
    {
        $body = ['body'];
        $this->requestMock->method('getParsedBody')->willReturn($body);
        $this->pageRepositoryMock->expects($this->once())->method('save')->with($body);
        $this->helperMock->method('create')->with(204)->willReturn($this->responseMock);
        $response = $this->handler->handle($this->requestMock);
        self::assertSame($this->responseMock, $response);
    }
}
