<?php

namespace Container;

use App\Container\TemplateEmitterProvider;
use PHPUnit\Framework\TestCase;
use Sx\Container\Injector;
use Sx\Template\Markdown\Text\TextMarkdownEmitter;
use Sx\Template\Template\Section\SectionEmitter;
use Sx\Template\Template\Section\SectionInterface;
use Sx\Template\Template\Template;
use Sx\Template\Template\Text\TextEmitter;
use Sx\Template\Template\Text\TextInterface;
use Sx\Template\Template\Title\TitleEmitter;
use Sx\Template\Template\Title\TitleInterface;

class TemplateEmitterProviderTest extends TestCase
{
    public function testProvide(): void
    {
        $injector = new Injector();
        $injector->set(SectionEmitter::class, $this->createMock(SectionInterface::class));
        $injector->set(TextMarkdownEmitter::class, $this->createMock(TextInterface::class));
        $injector->set(TitleEmitter::class, $this->createMock(TitleInterface::class));
        $provider = new TemplateEmitterProvider();
        $provider->provide($injector);
        self::assertNotNull(Template::get(SectionInterface::class));
        self::assertNotNull(Template::get(TextInterface::class));
        self::assertNotNull(Template::get(TitleInterface::class));
    }
}
