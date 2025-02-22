<?php

namespace App\Template;

use App\Storage\PageStorage;
use Sx\Template\PageValueProviderInterface;

/**
 * PageValueProviderInterface implementation to get the current selection from the database.
 */
class PageValueProvider implements PageValueProviderInterface
{
    private ?array $values = null;

    public function __construct(
        private readonly PageStorage $storage,
    ) {
    }

    /**
     * Returns the current selected value for type and key from the database.
     *
     * Database access is only done once for all selections for performance.
     * It is (safely) assumed that the one-page template will always need all selected values.
     *
     * @param string $type
     * @param string $key
     *
     * @return mixed
     */
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
