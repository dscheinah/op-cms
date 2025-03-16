<?php

namespace Template;

use App\Storage\CalendarStorage;
use App\Template\CalendarValueProvider;
use DateTime;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sx\Template\Template\Calendar\DTO\CalendarDTO;
use Sx\Template\Template\Calendar\DTO\CalendarEntryDTO;

class CalendarValueProviderTest extends TestCase
{
    private CalendarValueProvider $calendarValueProvider;

    private MockObject $calendarStorageMock;

    protected function setUp(): void
    {
        $this->calendarStorageMock = $this->createMock(CalendarStorage::class);
        $this->calendarValueProvider = new CalendarValueProvider(
            $this->calendarStorageMock,
        );
    }

    public function testGet(): void
    {
        $expectedCalendarDTO = new CalendarDTO();
        $expectedCalendarDTO->list[] = new CalendarEntryDTO();
        $expectedCalendarDTO->list[] = new CalendarEntryDTO();
        $expectedCalendarDTO->list[0]->date = DateTime::createFromFormat('Y-m-d', '2025-01-01');
        $expectedCalendarDTO->list[0]->time = DateTime::createFromFormat('H:i:s', '23:42:00');
        $expectedCalendarDTO->list[0]->place = 'Place';
        $expectedCalendarDTO->list[0]->title = 'Title';
        $expectedCalendarDTO->list[0]->description = 'Description';
        $expectedCalendarDTO->list[0]->link = 'Link';
        $expectedCalendarDTO->list[1]->date = DateTime::createFromFormat('Y-m-d', '2025-12-24');
        $expectedCalendarDTO->list[1]->title = 'Title 2';

        $this->calendarStorageMock->expects($this->once())->method('fetchAllFuture')
            ->willReturnCallback(function () {
                yield ['date' => '2025-01-01', 'time' => '23:42:00', 'place' => 'Place', 'title' => 'Title', 'description' => 'Description', 'link' => 'Link'];
                yield ['date' => '2025-12-24', 'time' => null, 'place' => null, 'title' => 'Title 2', 'description' => null, 'link' => null];
            });

        self::assertEquals($expectedCalendarDTO, $this->calendarValueProvider->calendar());
        self::assertEquals($expectedCalendarDTO, $this->calendarValueProvider->calendar());
    }
}
