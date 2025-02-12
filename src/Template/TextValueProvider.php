<?php

namespace App\Template;

use App\Storage\TextStorage;
use Sx\Template\TextValueProviderInterface;

class TextValueProvider implements TextValueProviderInterface
{
    public function __construct(
        private readonly TextStorage $storage,
    ) {
    }

    public function get(mixed $value): string
    {
        return $this->storage->fetchOne((int) $value)['content'] ?? '';
    }
}
