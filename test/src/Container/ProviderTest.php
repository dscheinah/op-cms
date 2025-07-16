<?php

namespace Container;

use App\Container\Provider;
use App\Handler\CalendarLoadHandler;
use App\Handler\CalendarRemoveHandler;
use App\Handler\CalendarSaveHandler;
use App\Handler\GalleryListHandler;
use App\Handler\GalleryLoadHandler;
use App\Handler\GalleryRemoveHandler;
use App\Handler\GallerySaveHandler;
use App\Handler\ImageListHandler;
use App\Handler\ImageLoadHandler;
use App\Handler\ImageRemoveHandler;
use App\Handler\ImageSaveHandler;
use App\Handler\PageLoadHandler;
use App\Handler\PageSaveHandler;
use App\Handler\TextListHandler;
use App\Handler\TextLoadHandler;
use App\Handler\TextRemoveHandler;
use App\Handler\TextSaveHandler;
use App\Repository\CalendarRepository;
use App\Repository\GalleryRepository;
use App\Repository\ImageRepository;
use App\Repository\PageRepository;
use App\Repository\TextRepository;
use App\Storage\CalendarStorage;
use App\Storage\ImageStorage;
use App\Storage\PageStorage;
use App\Storage\TextStorage;
use PHPUnit\Framework\TestCase;
use Sx\Container\Injector;
use Sx\Data\BackendInterface;
use Sx\Server\ApplicationInterface;
use Sx\Server\RouterInterface;
use Sx\Template\CalendarValueProviderInterface;
use Sx\Template\Collector\Collector;
use Sx\Template\Image\GalleryValueProviderInterface;
use Sx\Template\Image\ImageValueProviderInterface;
use Sx\Template\Image\Template\ImageEmitter;
use Sx\Template\Markdown\Text\TextMarkdownEmitter;
use Sx\Template\PageValueProviderInterface;
use Sx\Template\TextValueProviderInterface;

class ProviderTest extends TestCase
{
    public function testProvide(): void
    {
        $injector = new Injector();
        $provider = new Provider();
        $provider->provide($injector);
        self::assertTrue($injector->has(Collector::class));
        self::assertTrue($injector->has(TextMarkdownEmitter::class));
        self::assertTrue($injector->has(ImageEmitter::class));
        self::assertTrue($injector->has(ApplicationInterface::class));
        self::assertTrue($injector->has(RouterInterface::class));
        self::assertTrue($injector->has(BackendInterface::class));
        self::assertTrue($injector->has(CalendarLoadHandler::class));
        self::assertTrue($injector->has(CalendarSaveHandler::class));
        self::assertTrue($injector->has(CalendarRemoveHandler::class));
        self::assertTrue($injector->has(PageLoadHandler::class));
        self::assertTrue($injector->has(PageSaveHandler::class));
        self::assertTrue($injector->has(TextListHandler::class));
        self::assertTrue($injector->has(TextLoadHandler::class));
        self::assertTrue($injector->has(TextRemoveHandler::class));
        self::assertTrue($injector->has(TextSaveHandler::class));
        self::assertTrue($injector->has(ImageListHandler::class));
        self::assertTrue($injector->has(ImageLoadHandler::class));
        self::assertTrue($injector->has(ImageRemoveHandler::class));
        self::assertTrue($injector->has(ImageSaveHandler::class));
        self::assertTrue($injector->has(GalleryListHandler::class));
        self::assertTrue($injector->has(GalleryLoadHandler::class));
        self::assertTrue($injector->has(GalleryRemoveHandler::class));
        self::assertTrue($injector->has(GallerySaveHandler::class));
        self::assertTrue($injector->has(CalendarRepository::class));
        self::assertTrue($injector->has(GalleryRepository::class));
        self::assertTrue($injector->has(ImageRepository::class));
        self::assertTrue($injector->has(PageRepository::class));
        self::assertTrue($injector->has(TextRepository::class));
        self::assertTrue($injector->has(CalendarStorage::class));
        self::assertTrue($injector->has(ImageStorage::class));
        self::assertTrue($injector->has(PageStorage::class));
        self::assertTrue($injector->has(TextStorage::class));
        self::assertTrue($injector->has(CalendarValueProviderInterface::class));
        self::assertTrue($injector->has(GalleryValueProviderInterface::class));
        self::assertTrue($injector->has(ImageValueProviderInterface::class));
        self::assertTrue($injector->has(PageValueProviderInterface::class));
        self::assertTrue($injector->has(TextValueProviderInterface::class));
    }
}
