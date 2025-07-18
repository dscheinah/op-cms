<?php

namespace Container;

use App\Container\TemplateEmitterProvider;
use PHPUnit\Framework\TestCase;
use Sx\Container\Injector;
use Sx\Template\Image\Template\GalleryEmitter;
use Sx\Template\Image\Template\GalleryInterface;
use Sx\Template\Image\Template\ImageEmitter;
use Sx\Template\Image\Template\ImageInterface;
use Sx\Template\Markdown\Text\TextMarkdownEmitter;
use Sx\Template\Template\Calendar\CalendarEmitter;
use Sx\Template\Template\Calendar\CalendarInterface;
use Sx\Template\Template\Section\SectionEmitter;
use Sx\Template\Template\Section\SectionInterface;
use Sx\Template\Template\Template;
use Sx\Template\Template\Text\TextInterface;
use Sx\Template\Template\Title\TitleEmitter;
use Sx\Template\Template\Title\TitleInterface;

class TemplateEmitterProviderTest extends TestCase
{
    public function testProvide(): void
    {
        $injector = new Injector();
        $injector->set(CalendarEmitter::class, $this->createMock(CalendarInterface::class));
        $injector->set(GalleryEmitter::class, $this->createMock(GalleryInterface::class));
        $injector->set(ImageEmitter::class, $this->createMock(ImageInterface::class));
        $injector->set(SectionEmitter::class, $this->createMock(SectionInterface::class));
        $injector->set(TextMarkdownEmitter::class, $this->createMock(TextInterface::class));
        $injector->set(TitleEmitter::class, $this->createMock(TitleInterface::class));
        $provider = new TemplateEmitterProvider();
        $provider->provide($injector);
        self::assertNotNull(Template::get(CalendarInterface::class));
        self::assertNotNull(Template::get(GalleryInterface::class));
        self::assertNotNull(Template::get(ImageInterface::class));
        self::assertNotNull(Template::get(SectionInterface::class));
        self::assertNotNull(Template::get(TextInterface::class));
        self::assertNotNull(Template::get(TitleInterface::class));
    }
}
