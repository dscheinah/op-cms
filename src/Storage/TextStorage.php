<?php

namespace App\Storage;

use Generator;
use Sx\Data\Storage;

class TextStorage extends Storage
{
    public function fetchAll(): Generator
    {
        yield from $this->fetch('SELECT `id`, `name` FROM `texts` ORDER BY `name`');
    }

    public function fetchOne(int $id): ?array
    {
        return $this->fetch('SELECT * FROM `texts` WHERE `id` = ?', [$id])->current();
    }

    public function create(string $name, string $content): void
    {
        $this->insert('INSERT INTO `texts` (`name`, `content`) VALUES (?, ?)', [$name, $content]);
    }

    public function update(int $id, string $name, string $content): void
    {
        $this->execute('UPDATE `texts` SET `name` = ?, `content` = ? WHERE `id` = ?', [$name, $content, $id]);
    }

    public function delete(int $id): void
    {
        $this->execute('DELETE FROM `texts` WHERE `id` = ?', [$id]);
    }
}
