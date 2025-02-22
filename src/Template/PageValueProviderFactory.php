<?php

namespace App\Template;

use App\Storage\PageStorage;
use Sx\Container\FactoryInterface;
use Sx\Container\Injector;

/**
 * Factory for the PageValueProvider.
 */
class PageValueProviderFactory implements FactoryInterface
{
    /**
     * Creates the provider with database access.
     *
     * @param Injector $injector
     * @param array $options
     * @param string $class
     *
     * @return PageValueProvider
     */
    public function create(Injector $injector, array $options, string $class): PageValueProvider
    {
        return new PageValueProvider(
            $injector->get(PageStorage::class),
        );
    }
}
