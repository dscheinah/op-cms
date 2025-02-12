<?php

namespace App\Repository;

use App\Storage\TextStorage;
use Sx\Container\FactoryInterface;
use Sx\Container\Injector;

class TextRepositoryFactory implements FactoryInterface
{
    public function create(Injector $injector, array $options, string $class): TextRepository
    {
        return new TextRepository(
            $injector->get(TextStorage::class),
        );
    }
}
