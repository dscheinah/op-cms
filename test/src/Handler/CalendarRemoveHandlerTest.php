<?php

namespace Handler;

use App\Handler\CalendarRemoveHandler;
use App\Repository\CalendarRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sx\Message\Response\ResponseHelperInterface;

class CalendarRemoveHandlerTest extends TestCase
{
    private CalendarRemoveHandler $handler;

    private MockObject $helperMock;

    private MockObject $calendarRepositoryMock;

    private MockObject $requestMock;

    private MockObject $responseMock;

    protected function setUp(): void
    {
        $this->helperMock = $this->createMock(ResponseHelperInterface::class);
        $this->calendarRepositoryMock = $this->createMock(CalendarRepository::class);
        $this->handler = new CalendarRemoveHandler(
            $this->helperMock,
            $this->calendarRepositoryMock,
        );
        $this->requestMock = $this->createMock(ServerRequestInterface::class);
        $this->responseMock = $this->createMock(ResponseInterface::class);
    }

    public function testHandle(): void
    {
        $id = 42;
        $this->requestMock->method('getQueryParams')->willReturn(['id' => $id]);
        $this->calendarRepositoryMock->expects($this->once())->method('remove');
        $this->helperMock->method('create')->with(204)->willReturn($this->responseMock);
        $response = $this->handler->handle($this->requestMock);
        $this->assertSame($this->responseMock, $response);
    }
}
