<?php

namespace App\Repository;

use App\Container\TemplateCollectorProvider;
use App\Storage\PageStorage;
use Sx\Container\FactoryInterface;
use Sx\Container\Injector;
use Sx\Template\Collector\Collector;

class PageRepositoryFactory implements FactoryInterface
{
    public function create(Injector $injector, array $options, string $class): PageRepository
    {
        $injector->setup(new TemplateCollectorProvider());
        return new PageRepository(
            $injector->get(PageStorage::class),
            $injector->get(Collector::class),
            $options['template'],
        );
    }
}
