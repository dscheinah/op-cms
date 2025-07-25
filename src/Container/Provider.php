<?php

namespace App\Container;

use App\ApplicationFactory;
use App\Handler\CalendarHandlerFactory;
use App\Handler\CalendarLoadHandler;
use App\Handler\CalendarRemoveHandler;
use App\Handler\CalendarSaveHandler;
use App\Handler\GalleryHandlerFactory;
use App\Handler\GalleryListHandler;
use App\Handler\GalleryLoadHandler;
use App\Handler\GalleryRemoveHandler;
use App\Handler\GallerySaveHandler;
use App\Handler\ImageHandlerFactory;
use App\Handler\ImageListHandler;
use App\Handler\ImageLoadHandler;
use App\Handler\ImageRemoveHandler;
use App\Handler\ImageSaveHandler;
use App\Handler\PageHandlerFactory;
use App\Handler\PageLoadHandler;
use App\Handler\PageSaveHandler;
use App\Handler\TextHandlerFactory;
use App\Handler\TextListHandler;
use App\Handler\TextLoadHandler;
use App\Handler\TextRemoveHandler;
use App\Handler\TextSaveHandler;
use App\Repository\CalendarRepository;
use App\Repository\CalendarRepositoryFactory;
use App\Repository\GalleryRepository;
use App\Repository\GalleryRepositoryFactory;
use App\Repository\ImageRepository;
use App\Repository\ImageRepositoryFactory;
use App\Repository\PageRepository;
use App\Repository\PageRepositoryFactory;
use App\Repository\TextRepository;
use App\Repository\TextRepositoryFactory;
use App\RouterFactory;
use App\Storage\CalendarStorage;
use App\Storage\GalleryStorage;
use App\Storage\ImageStorage;
use App\Storage\PageStorage;
use App\Storage\TextStorage;
use App\Template\CalendarValueProviderFactory;
use App\Template\GalleryValueProviderFactory;
use App\Template\ImageValueProviderFactory;
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
use Sx\Template\CalendarValueProviderInterface;
use Sx\Template\Container\TemplateProvider;
use Sx\Template\Image\Container\TemplateImageProvider;
use Sx\Template\Image\GalleryValueProviderInterface;
use Sx\Template\Image\ImageValueProviderInterface;
use Sx\Template\Markdown\Container\TemplateMarkdownProvider;
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
        $injector->setup(new TemplateImageProvider());
        $injector->setup(new TemplateMarkdownProvider());

        // Add all local classes and factories.
        $injector->set(ApplicationInterface::class, ApplicationFactory::class);
        $injector->set(RouterInterface::class, RouterFactory::class);

        $injector->set(BackendInterface::class, MySqlBackendFactory::class);

        $injector->set(CalendarLoadHandler::class, CalendarHandlerFactory::class);
        $injector->set(CalendarSaveHandler::class, CalendarHandlerFactory::class);
        $injector->set(CalendarRemoveHandler::class, CalendarHandlerFactory::class);
        $injector->set(GalleryListHandler::class, GalleryHandlerFactory::class);
        $injector->set(GalleryLoadHandler::class, GalleryHandlerFactory::class);
        $injector->set(GallerySaveHandler::class, GalleryHandlerFactory::class);
        $injector->set(GalleryRemoveHandler::class, GalleryHandlerFactory::class);
        $injector->set(ImageListHandler::class, ImageHandlerFactory::class);
        $injector->set(ImageLoadHandler::class, ImageHandlerFactory::class);
        $injector->set(ImageRemoveHandler::class, ImageHandlerFactory::class);
        $injector->set(ImageSaveHandler::class, ImageHandlerFactory::class);
        $injector->set(PageLoadHandler::class, PageHandlerFactory::class);
        $injector->set(PageSaveHandler::class, PageHandlerFactory::class);
        $injector->set(TextListHandler::class, TextHandlerFactory::class);
        $injector->set(TextLoadHandler::class, TextHandlerFactory::class);
        $injector->set(TextRemoveHandler::class, TextHandlerFactory::class);
        $injector->set(TextSaveHandler::class, TextHandlerFactory::class);

        $injector->set(CalendarRepository::class, CalendarRepositoryFactory::class);
        $injector->set(GalleryRepository::class, GalleryRepositoryFactory::class);
        $injector->set(ImageRepository::class, ImageRepositoryFactory::class);
        $injector->set(PageRepository::class, PageRepositoryFactory::class);
        $injector->set(TextRepository::class, TextRepositoryFactory::class);

        $injector->set(CalendarStorage::class, StorageFactory::class);
        $injector->set(GalleryStorage::class, StorageFactory::class);
        $injector->set(ImageStorage::class, StorageFactory::class);
        $injector->set(PageStorage::class, StorageFactory::class);
        $injector->set(TextStorage::class, StorageFactory::class);

        $injector->set(CalendarValueProviderInterface::class, CalendarValueProviderFactory::class);
        $injector->set(GalleryValueProviderInterface::class, GalleryValueProviderFactory::class);
        $injector->set(ImageValueProviderInterface::class, ImageValueProviderFactory::class);
        $injector->set(PageValueProviderInterface::class, PageValueProviderFactory::class);
        $injector->set(TextValueProviderInterface::class, TextValueProviderFactory::class);
    }
}
