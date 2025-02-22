<?php

namespace App\Repository;

use App\Container\TemplateCollectorProvider;
use App\Storage\PageStorage;
use Sx\Container\FactoryInterface;
use Sx\Container\Injector;
use Sx\Template\Collector\Collector;

/**
 * Factory for the page repository.
 */
class PageRepositoryFactory implements FactoryInterface
{
    /**
     * Creates the repository with access to the database and template collector.
     *
     * The repository will include the template file.
     * Therefore, the correct template implementations for the collector need to be provided.
     *
     * @param Injector $injector
     * @param array $options
     * @param string $class
     *
     * @return PageRepository
     */
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
