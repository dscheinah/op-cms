<?php

namespace Container;

use App\Container\TemplateCollectorProvider;
use PHPUnit\Framework\TestCase;
use Sx\Container\Injector;
use Sx\Template\Image\Template\GalleryCollector;
use Sx\Template\Image\Template\GalleryInterface;
use Sx\Template\Image\Template\ImageCollector;
use Sx\Template\Image\Template\ImageInterface;
use Sx\Template\Template\Calendar\CalendarCollector;
use Sx\Template\Template\Calendar\CalendarInterface;
use Sx\Template\Template\Section\SectionCollector;
use Sx\Template\Template\Section\SectionInterface;
use Sx\Template\Template\Template;
use Sx\Template\Template\Text\TextCollector;
use Sx\Template\Template\Text\TextInterface;
use Sx\Template\Template\Title\TitleCollector;
use Sx\Template\Template\Title\TitleInterface;

class TemplateCollectorProviderTest extends TestCase
{
    public function testProvide(): void
    {
        $injector = new Injector();
        $injector->set(CalendarCollector::class, $this->createMock(CalendarInterface::class));
        $injector->set(GalleryCollector::class, $this->createMock(GalleryInterface::class));
        $injector->set(ImageCollector::class, $this->createMock(ImageInterface::class));
        $injector->set(SectionCollector::class, $this->createMock(SectionInterface::class));
        $injector->set(TextCollector::class, $this->createMock(TextInterface::class));
        $injector->set(TitleCollector::class, $this->createMock(TitleInterface::class));
        $provider = new TemplateCollectorProvider();
        $provider->provide($injector);
        self::assertNotNull(Template::get(CalendarInterface::class));
        self::assertNotNull(Template::get(GalleryInterface::class));
        self::assertNotNull(Template::get(ImageInterface::class));
        self::assertNotNull(Template::get(SectionInterface::class));
        self::assertNotNull(Template::get(TextInterface::class));
        self::assertNotNull(Template::get(TitleInterface::class));
    }
}
