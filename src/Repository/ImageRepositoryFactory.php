<?php

namespace App\Repository;

use App\Storage\ImageStorage;
use Sx\Container\FactoryInterface;
use Sx\Container\Injector;
use Sx\Image\ImageRenderer;

/**
 * Factory for the image repository.
 */
class ImageRepositoryFactory implements FactoryInterface
{
    /**
     * Creates the repository with access to the database.
     *
     * @param Injector $injector
     * @param array $options
     * @param string $class
     *
     * @return ImageRepository
     */
    public function create(Injector $injector, array $options, string $class): ImageRepository
    {
        return new ImageRepository(
            $injector->get(ImageStorage::class),
            new ImageRenderer(),
            rtrim($options['image']['source'], '/'),
            rtrim($options['image']['cache'], '/'),
        );
    }
}
