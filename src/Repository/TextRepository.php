<?php

namespace App\Repository;

use App\Storage\TextStorage;

/**
 * Domain code to handle texts.
 */
class TextRepository
{
    public function __construct(
        private readonly TextStorage $storage,
    ) {
    }

    /**
     * Load all texts as an array in alphabetical order. The result will contain id and name for each text.
     *
     * @return array
     */
    public function list(): array
    {
        return iterator_to_array($this->storage->fetchAll());
    }

    /**
     * Load one text given by id or null if not found. The result will contain id, name and content.
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
        return $this->storage->fetchOne($id);
    }

    /**
     * Inserts text data containing at least name and content. If an id is present, updates an existing text.
     *
     * @param array $data
     *
     * @return void
     */
    public function save(array $data): void
    {
        if (isset($data['id'])) {
            $this->storage->update((int) $data['id'], $data['name'], $data['content']);
        } else {
            $this->storage->create($data['name'], $data['content']);
        }
    }

    /**
     * Delete the text by id.
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
