<?php

namespace App\Container;

use App\ApplicationFactory;
use App\Handler\PageLoadHandler;
use App\Handler\PageLoadHandlerFactory;
use App\Handler\PageSaveHandler;
use App\Handler\PageSaveHandlerFactory;
use App\Handler\TextHandlerFactory;
use App\Handler\TextListHandler;
use App\Handler\TextLoadHandler;
use App\Handler\TextRemoveHandler;
use App\Handler\TextSaveHandler;
use App\Repository\PageRepository;
use App\Repository\PageRepositoryFactory;
use App\Repository\TextRepository;
use App\Repository\TextRepositoryFactory;
use App\RouterFactory;
use App\Storage\PageStorage;
use App\Storage\TextStorage;
use App\Template\PageValueProviderFactory;
use App\Template\TextValueProviderFactory;
use Sx\Application\Container\ApplicationProvider;
use Sx\Container\Injector;
use Sx\Container\ProviderInterface;
use Sx\Data\Backend\MySqlBackendFactory;
use Sx\Data\BackendInterface;
use Sx\Data\StorageFactory;
use Sx\Log\Container\LogProvider;
use Sx\Message\Container\MessageProvider;
use Sx\Server\ApplicationInterface;
use Sx\Server\Container\ServerProvider;
use Sx\Server\RouterInterface;
use Sx\Template\Container\TemplateProvider;
use Sx\Template\PageValueProviderInterface;
use Sx\Template\TextValueProviderInterface;

/**
 * This class is used in index.php to set up the dependency injector.
 */
class Provider implements ProviderInterface
{
    /**
     * Adds all used mappings for interfaces and classes to factories.
     *
     * @param Injector $injector
     */
    public function provide(Injector $injector): void
    {
        // First do a setup of all modules installed by composer.
        $injector->setup(new ApplicationProvider());
        $injector->setup(new LogProvider());
        $injector->setup(new MessageProvider());
        $injector->setup(new ServerProvider());

        $injector->setup(new TemplateProvider());

        // Add all local classes and factories.
        $injector->set(ApplicationInterface::class, ApplicationFactory::class);
        $injector->set(RouterInterface::class, RouterFactory::class);

        $injector->set(BackendInterface::class, MySqlBackendFactory::class);

        $injector->set(PageLoadHandler::class, PageLoadHandlerFactory::class);
        $injector->set(PageSaveHandler::class, PageSaveHandlerFactory::class);
        $injector->set(TextListHandler::class, TextHandlerFactory::class);
        $injector->set(TextLoadHandler::class, TextHandlerFactory::class);
        $injector->set(TextRemoveHandler::class, TextHandlerFactory::class);
        $injector->set(TextSaveHandler::class, TextHandlerFactory::class);

        $injector->set(PageRepository::class, PageRepositoryFactory::class);
        $injector->set(TextRepository::class, TextRepositoryFactory::class);

        $injector->set(PageStorage::class, StorageFactory::class);
        $injector->set(TextStorage::class, StorageFactory::class);

        $injector->set(PageValueProviderInterface::class, PageValueProviderFactory::class);
        $injector->set(TextValueProviderInterface::class, TextValueProviderFactory::class);
    }
}
