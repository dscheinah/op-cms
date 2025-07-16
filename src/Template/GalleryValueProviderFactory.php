<?php

namespace App\Template;

use App\Storage\GalleryStorage;
use Sx\Container\FactoryInterface;
use Sx\Container\Injector;

class GalleryValueProviderFactory implements FactoryInterface
{
    /**
     * Creates the provider with database access.
     *
     * @param Injector $injector
     * @param array $options
     * @param string $class
     *
     * @return GalleryValueProvider
     */
    public function create(Injector $injector, array $options, string $class): GalleryValueProvider
    {
        return new GalleryValueProvider(
            $injector->get(GalleryStorage::class),
        );
    }
}
