<?php

namespace App\Repository;

use App\Storage\TextStorage;

class TextRepository
{
    public function __construct(
        private readonly TextStorage $storage,
    ) {
    }

    public function list(): array
    {
        return iterator_to_array($this->storage->fetchAll());
    }

    public function load(int $id): ?array
    {
        if (!$id) {
            return null;
        }
        return $this->storage->fetchOne($id);
    }

    public function save(array $data): void
    {
        if (isset($data['id'])) {
            $this->storage->update((int) $data['id'], $data['name'], $data['content']);
        } else {
            $this->storage->create($data['name'], $data['content']);
        }
    }

    public function remove(int $id): void
    {
        if (!$id) {
            return;
        }
        $this->storage->delete($id);
    }
}
