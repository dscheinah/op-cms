<?php

namespace Handler;

use App\Handler\PageLoadHandler;
use App\Repository\PageRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sx\Message\Response\ResponseHelperInterface;
use Sx\Template\Collector\DTO\CollectorDTO;

class PageLoadHandlerTest extends TestCase
{
    private PageLoadHandler $handler;

    private MockObject $helperMock;

    private MockObject $pageRepositoryMock;

    private MockObject $requestMock;

    private MockObject $responseMock;

    protected function setUp(): void
    {
        $this->helperMock = $this->createMock(ResponseHelperInterface::class);
        $this->pageRepositoryMock = $this->createMock(PageRepository::class);
        $this->handler = new PageLoadHandler(
            $this->helperMock,
            $this->pageRepositoryMock,
        );
        $this->requestMock = $this->createMock(ServerRequestInterface::class);
        $this->responseMock = $this->createMock(ResponseInterface::class);
    }

    public function testHandle(): void
    {
        $data = new CollectorDTO();
        $this->pageRepositoryMock->method('collect')->willReturn($data);
        $this->helperMock->method('create')->with(200, $data)->willReturn($this->responseMock);
        $response = $this->handler->handle($this->requestMock);
        self::assertSame($this->responseMock, $response);
    }
}
