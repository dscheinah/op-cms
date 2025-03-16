<?php

namespace App\Template;

use App\Storage\CalendarStorage;
use Sx\Container\FactoryInterface;
use Sx\Container\Injector;

class CalendarValueProviderFactory implements FactoryInterface
{
    /**
     * Creates the provider with database access.
     *
     * @param Injector $injector
     * @param array $options
     * @param string $class
     *
     * @return CalendarValueProvider
     */
    public function create(Injector $injector, array $options, string $class): CalendarValueProvider
    {
        return new CalendarValueProvider(
            $injector->get(CalendarStorage::class),
        );
    }
}
