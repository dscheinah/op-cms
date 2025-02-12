<?php

namespace App\Container;

use Sx\Container\Injector;
use Sx\Container\ProviderInterface;
use Sx\Template\Template\Section\SectionCollector;
use Sx\Template\Template\Section\SectionInterface;
use Sx\Template\Template\Template;
use Sx\Template\Template\Text\TextCollector;
use Sx\Template\Template\Text\TextInterface;
use Sx\Template\Template\Title\TitleCollector;
use Sx\Template\Template\Title\TitleInterface;

class TemplateCollectorProvider implements ProviderInterface
{
    public function provide(Injector $injector): void
    {
        Template::set(SectionInterface::class, $injector->get(SectionCollector::class));
        Template::set(TextInterface::class, $injector->get(TextCollector::class));
        Template::set(TitleInterface::class, $injector->get(TitleCollector::class));
    }
}
