<?php

namespace App\Container;

use Sx\Container\Injector;
use Sx\Container\ProviderInterface;
use Sx\Template\Template\Section\SectionEmitter;
use Sx\Template\Template\Section\SectionInterface;
use Sx\Template\Template\Template;
use Sx\Template\Template\Text\TextEmitter;
use Sx\Template\Template\Text\TextInterface;
use Sx\Template\Template\Title\TitleEmitter;
use Sx\Template\Template\Title\TitleInterface;

class TemplateEmitterProvider implements ProviderInterface
{
    public function provide(Injector $injector): void
    {
        Template::set(SectionInterface::class, $injector->get(SectionEmitter::class));
        Template::set(TextInterface::class, $injector->get(TextEmitter::class));
        Template::set(TitleInterface::class, $injector->get(TitleEmitter::class));
    }
}
