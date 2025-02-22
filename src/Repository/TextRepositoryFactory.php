<?php

namespace App\Repository;

use App\Storage\TextStorage;
use Sx\Container\FactoryInterface;
use Sx\Container\Injector;

/**
 * Factory for the text repository.
 */
class TextRepositoryFactory implements FactoryInterface
{
    /**
     * Creates the repository with access to the database.
     *
     * @param Injector $injector
     * @param array $options
     * @param string $class
     *
     * @return TextRepository
     */
    public function create(Injector $injector, array $options, string $class): TextRepository
    {
        return new TextRepository(
            $injector->get(TextStorage::class),
        );
    }
}
