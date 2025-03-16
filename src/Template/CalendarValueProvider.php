<?php

namespace App\Template;

use App\Storage\CalendarStorage;
use DateTime;
use Sx\Template\CalendarValueProviderInterface;
use Sx\Template\Template\Calendar\DTO\CalendarDTO;
use Sx\Template\Template\Calendar\DTO\CalendarEntryDTO;

class CalendarValueProvider implements CalendarValueProviderInterface
{
    private ?CalendarDTO $calendarDTO = null;

    public function __construct(
        private readonly CalendarStorage $storage,
    ) {
    }

    /**
     * Loads all possible calendar entries to render.
     *
     * The database values are transformed into the expected template data structure.
     *
     * @return CalendarDTO
     */
    public function calendar(): CalendarDTO
    {
        if ($this->calendarDTO === null) {
            $this->calendarDTO = new CalendarDTO();
            foreach ($this->storage->fetchAllFuture() as $entry) {
                $calendarEntryDTO = new CalendarEntryDTO();
                $calendarEntryDTO->date = DateTime::createFromFormat('Y-m-d', $entry['date']);
                $calendarEntryDTO->time = $entry['time'] ? DateTime::createFromFormat('H:i:s', $entry['time']) : null;
                $calendarEntryDTO->place = $entry['place'] ?: null;
                $calendarEntryDTO->title = $entry['title'];
                $calendarEntryDTO->description = $entry['description'] ?: null;
                $calendarEntryDTO->link = $entry['link'] ?: null;
                $this->calendarDTO->list[] = $calendarEntryDTO;
            }
        }
        return $this->calendarDTO;
    }
}
