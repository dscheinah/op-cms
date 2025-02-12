<?php

namespace App\Template;

use App\Storage\TextStorage;
use Sx\Container\FactoryInterface;
use Sx\Container\Injector;

class TextValueProviderFactory implements FactoryInterface
{
    public function create(Injector $injector, array $options, string $class): TextValueProvider
    {
        return new TextValueProvider(
            $injector->get(TextStorage::class),
        );
    }
}
