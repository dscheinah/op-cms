<?php

namespace App\Container;

use Sx\Container\Injector;
use Sx\Container\ProviderInterface;
use Sx\Template\Template\Calendar\CalendarCollector;
use Sx\Template\Template\Calendar\CalendarInterface;
use Sx\Template\Template\Section\SectionCollector;
use Sx\Template\Template\Section\SectionInterface;
use Sx\Template\Template\Template;
use Sx\Template\Template\Text\TextCollector;
use Sx\Template\Template\Text\TextInterface;
use Sx\Template\Template\Title\TitleCollector;
use Sx\Template\Template\Title\TitleInterface;

class TemplateCollectorProvider implements ProviderInterface
{
    /**
     * Registers the template implementations used to provide all required data for the CMS app.
     *
     * This is called from the PageRepositoryFactory to provide a way to load the current (available) selections.
     *
     * @param Injector $injector
     *
     * @return void
     */
    public function provide(Injector $injector): void
    {
        Template::set(CalendarInterface::class, $injector->get(CalendarCollector::class));
        Template::set(SectionInterface::class, $injector->get(SectionCollector::class));
        Template::set(TextInterface::class, $injector->get(TextCollector::class));
        Template::set(TitleInterface::class, $injector->get(TitleCollector::class));
    }
}
