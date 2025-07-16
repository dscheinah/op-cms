<?php

namespace App\Storage;

use Generator;
use Sx\Data\Storage;

/**
 * Database implementation for the `images` table.
 */
class ImageStorage extends Storage
{
    /**
     * Load id, file and name from all images in alphabetical order.
     *
     * @return Generator
     */
    public function fetchAll(?int $gallery): Generator
    {
        if ($gallery) {
            yield from $this->fetch(
                'SELECT `id`, `file`, `name` FROM `images` 
                    INNER JOIN `galleries_x_images` ON `id` = `image_id` 
                    WHERE `gallery_id` = ? 
                    ORDER BY `sort`',
                [$gallery]
            );
        } else {
            yield from $this->fetch('SELECT `id`, `file`, `name` FROM `images` ORDER BY `name`');
        }
    }

    /**
     * Load one image.
     *
     * @param int $id
     *
     * @return array|null
     */
    public function fetchOne(int $id): ?array
    {
        return $this->fetch('SELECT * FROM `images` WHERE `id` = ?', [$id])->current();
    }

    /**
     * Insert an image.
     *
     * @param string $name
     * @param string $src
     * @param string $alt
     * @param string $title
     *
     * @return void
     */
    public function create(
        string $file,
        string $name,
        string $src,
        string $alt,
        string $title,
    ): void {
        $this->insert(
            'INSERT INTO `images` (`file`, `name`, `src`, `alt`, `title`) VALUES (?, ?, ?, ?, ?)',
            [$file, $name, $src, $alt, $title]
        );
    }

    /**
     * Update an image.
     *
     * @param int $id
     * @param string $name
     * @param string $src
     * @param string $alt
     * @param string $title
     *
     * @return void
     */
    public function update(
        int $id,
        string $name,
        string $src,
        string $alt,
        string $title,
    ): void {
        $this->execute(
            'UPDATE `images` SET `name` = ?, `src` = ?, `alt` = ?, `title` = ? WHERE `id` = ?',
            [$name, $src, $alt, $title, $id]
        );
    }

    /**
     * Delete an image.
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void
    {
        $this->execute('DELETE FROM `images` WHERE `id` = ?', [$id]);
    }
}
