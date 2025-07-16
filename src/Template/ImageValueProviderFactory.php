<?php

namespace App\Template;

use App\Storage\ImageStorage;
use Sx\Container\FactoryInterface;
use Sx\Container\Injector;

class ImageValueProviderFactory implements FactoryInterface
{
    /**
     * Creates the provider with database access and image source directory.
     *
     * @param Injector $injector
     * @param array $options
     * @param string $class
     *
     * @return ImageValueProvider
     */
    public function create(Injector $injector, array $options, string $class): ImageValueProvider
    {
        return new ImageValueProvider(
            $injector->get(ImageStorage::class),
            rtrim($options['image']['source'], '/'),
        );
    }
}
