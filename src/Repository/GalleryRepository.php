<?php

namespace App\Repository;

use App\Storage\GalleryStorage;

/**
 * Domain code to handle galleries.
 */
class GalleryRepository
{
    public function __construct(
        private readonly GalleryStorage $storage,
    ) {
    }

    /**
     * Load all galleries as an array in alphabetical order. The result will contain id and name for each gallery.
     *
     * @return array
     */
    public function list(): array
    {
        return iterator_to_array($this->storage->fetchAll());
    }

    /**
     * Load one gallery given by id or null if not found. The result will contain id, name and assigned images.
     *
     * @param int $id
     *
     * @return array|null
     */
    public function load(int $id): ?array
    {
        if (!$id) {
            return null;
        }
        $gallery = $this->storage->fetchOne($id);
        if (!$gallery) {
            return null;
        }
        $gallery['images'] = array_column(iterator_to_array($this->storage->fetchImages($id)), 'image_id');
        return $gallery;
    }

    /**
     * Inserts gallery data containing at least the name. If an id is present, update an existing gallery.
     *
     * @param array $data
     *
     * @return void
     */
    public function save(array $data): void
    {
        $id = (int) ($data['id'] ?? 0);
        if ($id) {
            $this->storage->update($data['id'], $data['name']);
        } else {
            $id = $this->storage->create($data['name']);
        }

        $this->storage->deleteImageAssignment($id);
        foreach (array_values($data['images'] ?? []) as $index => $image) {
            $this->storage->insertImageAssignment($id, (int) $image, $index);
        }
    }

    /**
     * Delete the gallery by id.
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
