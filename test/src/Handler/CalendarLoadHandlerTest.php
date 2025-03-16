<?php

namespace Handler;

use App\Handler\CalendarLoadHandler;
use App\Repository\CalendarRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sx\Message\Response\ResponseHelperInterface;

class CalendarLoadHandlerTest extends TestCase
{
    private CalendarLoadHandler $handler;

    private MockObject $helperMock;

    private MockObject $calendarRepositoryMock;

    private MockObject $requestMock;

    private MockObject $responseMock;

    protected function setUp(): void
    {
        $this->helperMock = $this->createMock(ResponseHelperInterface::class);
        $this->calendarRepositoryMock = $this->createMock(CalendarRepository::class);
        $this->handler = new CalendarLoadHandler(
            $this->helperMock,
            $this->calendarRepositoryMock,
        );
        $this->requestMock = $this->createMock(ServerRequestInterface::class);
        $this->responseMock = $this->createMock(ResponseInterface::class);
    }

    public function testHandle(): void
    {
        $data = ['data'];
        $this->calendarRepositoryMock->method('load')->willReturn($data);
        $this->helperMock->method('create')->with(200, $data)->willReturn($this->responseMock);
        $response = $this->handler->handle($this->requestMock);
        $this->assertSame($this->responseMock, $response);
    }
}
