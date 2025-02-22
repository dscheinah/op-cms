<?php

namespace App\Storage;

use Generator;
use Sx\Data\Storage;

/**
 * Database implementation for the `page` table.
 */
class PageStorage extends Storage
{
    /**
     * Fetch all data from the table.
     *
     * @return Generator
     */
    public function fetchAll(): Generator
    {
        yield from $this->fetch('SELECT * FROM `page`');
    }

    /**
     * Insert or update the data in the table.
     *
     * @param string $type
     * @param string $key
     * @param int $value
     *
     * @return void
     */
    public function save(string $type, string $key, int $value): void
    {
        $statement = 'INSERT INTO `page` (`type`, `key`, `value`) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = ?';
        $this->execute($statement, [$type, $key, $value, $value]);
    }
}
