<?php

namespace App\Storage;

use Generator;
use Sx\Data\Storage;

/**
 * Database implementation for the `galleries` and `galleries_x_images` tables.
 */
class GalleryStorage extends Storage
{
    /**
     * Load id and name from all galleries in alphabetical order.
     *
     * @return Generator
     */
    public function fetchAll(): Generator
    {
        yield from $this->fetch('SELECT `id`, `name` FROM `galleries` ORDER BY `name`');
    }

    /**
     * Load one gallery.
     *
     * @param int $id
     *
     * @return array|null
     */
    public function fetchOne(int $id): ?array
    {
        return $this->fetch('SELECT * FROM `galleries` WHERE `id` = ?', [$id])->current();
    }

    /**
     * Insert a gallery.
     *
     * @param string $name
     *
     * @return int
     */
    public function create(string $name): int {
        return $this->insert('INSERT INTO `galleries` (`name`) VALUES (?)', [$name]);
    }

    /**
     * Update a gallery.
     *
     * @param int $id
     * @param string $name
     *
     * @return void
     */
    public function update(int $id, string $name): void {
        $this->execute('UPDATE `galleries` SET `name` = ? WHERE `id` = ?', [$name, $id]);
    }

    /**
     * Delete a gallery.
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void
    {
        $this->execute('DELETE FROM `galleries` WHERE `id` = ?', [$id]);
    }

    /**
     * Loads all assigned image ids for the given gallery.
     *
     * @param int $galleryId
     *
     * @return Generator
     */
    public function fetchImages(int $galleryId): Generator
    {
        return $this->fetch(
            'SELECT `image_id` FROM `galleries_x_images` WHERE `gallery_id` = ? ORDER BY `sort`',
            [$galleryId]
        );
    }

    /**
     * Removes all assigned images for the given gallery.
     *
     * @param int $galleryId
     *
     * @return void
     */
    public function deleteImageAssignment(int $galleryId): void
    {
        $this->execute('DELETE FROM `galleries_x_images` WHERE `gallery_id` = ?', [$galleryId]);
    }

    /**
     * Inserts a new assigned image for the given gallery in order.
     *
     * @param int $galleryId
     * @param int $imageId
     * @param int $sort
     *
     * @return void
     */
    public function insertImageAssignment(int $galleryId, int $imageId, int $sort): void
    {
        $this->insert(
            'INSERT INTO `galleries_x_images` (`gallery_id`, `image_id`, `sort`) VALUES (?, ?, ?)',
            [$galleryId, $imageId, $sort]
        );
    }
}
