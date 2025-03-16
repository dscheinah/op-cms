<?php

namespace Handler;

use App\Handler\CalendarSaveHandler;
use App\Repository\CalendarRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sx\Message\Response\ResponseHelperInterface;

class CalendarSaveHandlerTest extends TestCase
{
    private CalendarSaveHandler $handler;

    private MockObject $helperMock;

    private MockObject $calendarRepositoryMock;

    private MockObject $requestMock;

    private MockObject $responseMock;

    protected function setUp(): void
    {
        $this->helperMock = $this->createMock(ResponseHelperInterface::class);
        $this->calendarRepositoryMock = $this->createMock(CalendarRepository::class);
        $this->handler = new CalendarSaveHandler(
            $this->helperMock,
            $this->calendarRepositoryMock,
        );
        $this->requestMock = $this->createMock(ServerRequestInterface::class);
        $this->responseMock = $this->createMock(ResponseInterface::class);
    }

    public function testHandle(): void
    {
        $body = ['body'];
        $this->requestMock->method('getParsedBody')->willReturn($body);
        $this->calendarRepositoryMock->expects($this->once())->method('save')->with($body);
        $this->helperMock->method('create')->with(204)->willReturn($this->responseMock);
        $response = $this->handler->handle($this->requestMock);
        self::assertSame($this->responseMock, $response);
    }
}
