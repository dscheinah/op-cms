<?php

namespace App\Template;

use App\Storage\PageStorage;
use Sx\Container\FactoryInterface;
use Sx\Container\Injector;

class PageValueProviderFactory implements FactoryInterface
{
    public function create(Injector $injector, array $options, string $class): PageValueProvider
    {
        return new PageValueProvider(
            $injector->get(PageStorage::class),
        );
    }
}
