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
    /**
     * Registers the template implementations used to render the page.
     *
     * This is called from the main index.php of the website (e.g., example/public/index.php).
     *
     * @param Injector $injector
     *
     * @return void
     */
    public function provide(Injector $injector): void
    {
        Template::set(SectionInterface::class, $injector->get(SectionEmitter::class));
        Template::set(TextInterface::class, $injector->get(TextEmitter::class));
        Template::set(TitleInterface::class, $injector->get(TitleEmitter::class));
    }
}
