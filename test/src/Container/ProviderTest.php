<?php

namespace Container;

use App\Container\Provider;
use App\Handler\PageLoadHandler;
use App\Handler\PageSaveHandler;
use App\Handler\TextListHandler;
use App\Handler\TextLoadHandler;
use App\Handler\TextRemoveHandler;
use App\Handler\TextSaveHandler;
use App\Repository\PageRepository;
use App\Repository\TextRepository;
use App\Storage\PageStorage;
use App\Storage\TextStorage;
use PHPUnit\Framework\TestCase;
use Sx\Container\Injector;
use Sx\Data\BackendInterface;
use Sx\Server\ApplicationInterface;
use Sx\Server\RouterInterface;
use Sx\Template\Collector\Collector;
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
        self::assertTrue($injector->has(ApplicationInterface::class));
        self::assertTrue($injector->has(RouterInterface::class));
        self::assertTrue($injector->has(BackendInterface::class));
        self::assertTrue($injector->has(PageLoadHandler::class));
        self::assertTrue($injector->has(PageSaveHandler::class));
        self::assertTrue($injector->has(TextListHandler::class));
        self::assertTrue($injector->has(TextLoadHandler::class));
        self::assertTrue($injector->has(TextRemoveHandler::class));
        self::assertTrue($injector->has(TextSaveHandler::class));
        self::assertTrue($injector->has(PageRepository::class));
        self::assertTrue($injector->has(TextRepository::class));
        self::assertTrue($injector->has(PageStorage::class));
        self::assertTrue($injector->has(TextStorage::class));
        self::assertTrue($injector->has(PageValueProviderInterface::class));
        self::assertTrue($injector->has(TextValueProviderInterface::class));
    }
}
