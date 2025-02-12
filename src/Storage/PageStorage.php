<?php

namespace App\Storage;

use Generator;
use Sx\Data\Storage;

class PageStorage extends Storage
{
    public function fetchAll(): Generator
    {
        yield from $this->fetch('SELECT * FROM `page`');
    }

    public function save(string $type, string $key, int $value): void
    {
        $statement = 'INSERT INTO `page` (`type`, `key`, `value`) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = ?';
        $this->execute($statement, [$type, $key, $value, $value]);
    }
}
