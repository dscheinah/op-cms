<?php

namespace App\Template;

use App\Storage\PageStorage;
use Sx\Template\PageValueProviderInterface;

class PageValueProvider implements PageValueProviderInterface
{
    private ?array $values = null;

    public function __construct(
        private readonly PageStorage $storage,
    ) {
    }

    public function get(string $type, string $key): mixed
    {
        if ($this->values === null) {
            foreach ($this->storage->fetchAll() as $entry) {
                $this->values[$entry['type']][$entry['key']] = $entry['value'];
            }
        }
        return $this->values[$type][$key] ?? null;
    }
}
