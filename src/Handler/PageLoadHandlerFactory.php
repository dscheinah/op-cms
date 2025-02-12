<?php

namespace App\Handler;

use App\Repository\PageRepository;
use Sx\Container\FactoryInterface;
use Sx\Container\Injector;
use Sx\Message\Response\ResponseHelperInterface;

class PageLoadHandlerFactory implements FactoryInterface
{
    public function create(Injector $injector, array $options, string $class): PageLoadHandler
    {
        return new PageLoadHandler(
            $injector->get(ResponseHelperInterface::class),
            $injector->get(PageRepository::class),
        );
    }
}
