<?php

namespace App\Template;

use App\Storage\TextStorage;
use Sx\Template\TextValueProviderInterface;

/**
 * TextValueProviderInterface implementation to get the content to render.
 */
class TextValueProvider implements TextValueProviderInterface
{
    public function __construct(
        private readonly TextStorage $storage,
    ) {
    }

    /**
     * Return the content to render from the database for one selected text.
     *
     * @param mixed $value
     *
     * @return string
     */
    public function get(mixed $value): string
    {
        return $this->storage->fetchOne((int) $value)['content'] ?? '';
    }
}
