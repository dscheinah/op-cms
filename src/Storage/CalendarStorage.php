<?php

namespace App\Storage;

use Generator;
use Sx\Data\Storage;

class CalendarStorage extends Storage
{
    /**
     * Loads all database information for calendar entries starting today in order of date and time.
     *
     * @return Generator
     */
    public function fetchAllFuture(): Generator
    {
        return $this->fetch('SELECT * FROM `calendar` WHERE `date` >= DATE(NOW()) ORDER BY `date`, `time`');
    }

    /**
     * Creates a new calendar entry.
     *
     * @param string $date
     * @param string|null $time
     * @param string|null $place
     * @param string $title
     * @param string|null $description
     * @param string|null $link
     *
     * @return void
     */
    public function create(
        string $date,
        ?string $time,
        ?string $place,
        string $title,
        ?string $description,
        ?string $link
    ): void {
        $this->insert(
            'INSERT INTO `calendar` (`date`, `time`, `place`, `title`, `description`, `link`) VALUES (?, ?, ?, ?, ?, ?)',
            [$date, $time, $place, $title, $description, $link]
        );
    }

    /**
     * Updates an existing calendar entry.
     *
     * @param int $id
     * @param string $date
     * @param string|null $time
     * @param string|null $place
     * @param string $title
     * @param string|null $description
     * @param string|null $link
     *
     * @return void
     */
    public function update(
        int $id,
        string $date,
        ?string $time,
        ?string $place,
        string $title,
        ?string $description,
        ?string $link
    ): void {
        $this->execute(
            'UPDATE `calendar` SET `date` = ?, `time` = ?, `place` = ?, `title` = ?, `description` = ?, `link` = ? WHERE `id` = ?',
            [$date, $time, $place, $title, $description, $link, $id]
        );
    }

    /**
     * Deletes a calendar entry.
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void
    {
        $this->execute('DELETE FROM `calendar` WHERE `id` = ?', [$id]);
    }
}
