<?php

namespace App\Repository;

use App\Storage\CalendarStorage;
use Sx\Container\FactoryInterface;
use Sx\Container\Injector;

class CalendarRepositoryFactory implements FactoryInterface
{
    /**
     * Creates the repository with access to the database.
     *
     * @param Injector $injector
     * @param array $options
     * @param string $class
     *
     * @return CalendarRepository
     */
    public function create(Injector $injector, array $options, string $class): CalendarRepository
    {
        return new CalendarRepository(
            $injector->get(CalendarStorage::class),
        );
    }
}
