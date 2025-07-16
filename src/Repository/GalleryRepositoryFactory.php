<?php

namespace App\Repository;

use App\Storage\GalleryStorage;
use Sx\Container\FactoryInterface;
use Sx\Container\Injector;

/**
 * Factory for the gallery repository.
 */
class GalleryRepositoryFactory implements FactoryInterface
{
    /**
     * Creates the repository with access to the database.
     *
     * @param Injector $injector
     * @param array $options
     * @param string $class
     *
     * @return GalleryRepository
     */
    public function create(Injector $injector, array $options, string $class): GalleryRepository
    {
        return new GalleryRepository(
            $injector->get(GalleryStorage::class),
        );
    }
}
