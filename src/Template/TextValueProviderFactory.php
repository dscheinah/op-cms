<?php

namespace App\Template;

use App\Storage\TextStorage;
use Sx\Container\FactoryInterface;
use Sx\Container\Injector;

/**
 * Factory for the TextValueProvider.
 */
class TextValueProviderFactory implements FactoryInterface
{
    /**
     * Creates the provider with database access.
     *
     * @param Injector $injector
     * @param array $options
     * @param string $class
     *
     * @return TextValueProvider
     */
    public function create(Injector $injector, array $options, string $class): TextValueProvider
    {
        return new TextValueProvider(
            $injector->get(TextStorage::class),
        );
    }
}
