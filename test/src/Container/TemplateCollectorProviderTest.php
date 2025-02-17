<?php

namespace Container;

use App\Container\TemplateCollectorProvider;
use PHPUnit\Framework\TestCase;
use Sx\Container\Injector;
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
        $injector->set(SectionCollector::class, $this->createMock(SectionInterface::class));
        $injector->set(TextCollector::class, $this->createMock(TextInterface::class));
        $injector->set(TitleCollector::class, $this->createMock(TitleInterface::class));
        $provider = new TemplateCollectorProvider();
        $provider->provide($injector);
        self::assertNotNull(Template::get(SectionInterface::class));
        self::assertNotNull(Template::get(TextInterface::class));
        self::assertNotNull(Template::get(TitleInterface::class));
    }
}
