<?php

namespace App\Storage;

use Generator;
use Sx\Data\Storage;

/**
 * Database implementation for the `texts` table.
 */
class TextStorage extends Storage
{
    /**
     * Load id and name from all texts in alphabetical order.
     *
     * @return Generator
     */
    public function fetchAll(): Generator
    {
        yield from $this->fetch('SELECT `id`, `name` FROM `texts` ORDER BY `name`');
    }

    /**
     * Load one text.
     *
     * @param int $id
     *
     * @return array|null
     */
    public function fetchOne(int $id): ?array
    {
        return $this->fetch('SELECT * FROM `texts` WHERE `id` = ?', [$id])->current();
    }

    /**
     * Insert a text.
     *
     * @param string $name
     * @param string $content
     *
     * @return void
     */
    public function create(string $name, string $content): void
    {
        $this->insert('INSERT INTO `texts` (`name`, `content`) VALUES (?, ?)', [$name, $content]);
    }

    /**
     * Update a text.
     *
     * @param int $id
     * @param string $name
     * @param string $content
     *
     * @return void
     */
    public function update(int $id, string $name, string $content): void
    {
        $this->execute('UPDATE `texts` SET `name` = ?, `content` = ? WHERE `id` = ?', [$name, $content, $id]);
    }

    /**
     * Delete a text.
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void
    {
        $this->execute('DELETE FROM `texts` WHERE `id` = ?', [$id]);
    }
}
