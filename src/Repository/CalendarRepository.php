<?php

namespace App\Repository;

use App\Storage\CalendarStorage;

class CalendarRepository
{
    public function __construct(
        private readonly CalendarStorage $storage,
    ) {
    }

    /**
     * Loads all future calendar entries in order of date and time.
     *
     * The result will contain id, date, time, place, title, description and link.
     *
     * @return array
     */
    public function load(): array
    {
        return iterator_to_array($this->storage->fetchAllFuture());
    }

    /**
     * Saves the given data containing at least date and title.
     *
     * If an id is given, the corresponding calendar entry is updated.
     *
     * @param array $data
     *
     * @return void
     */
    public function save(array $data): void
    {
        $values = [
            $data['date'],
            $data['time'] ?: null,
            $data['place'] ?: null,
            $data['title'],
            $data['description'] ?: null,
            $data['link'] ?: null,
        ];
        if (isset($data['id'])) {
            $this->storage->update((int) $data['id'], ...$values);
        } else {
            $this->storage->create(...$values);
        }
    }

    /**
     * Removes the given calendar entry.
     *
     * @param int $id
     *
     * @return void
     */
    public function remove(int $id): void
    {
        if (!$id) {
            return;
        }
        $this->storage->delete($id);
    }
}
