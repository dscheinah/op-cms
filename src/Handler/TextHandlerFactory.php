<?php

namespace App\Handler;

use App\Repository\TextRepository;
use Sx\Container\FactoryInterface;
use Sx\Container\Injector;
use Sx\Message\Response\ResponseHelperInterface;

class TextHandlerFactory implements FactoryInterface
{
    public function create(Injector $injector, array $options, string $class): object
    {
        return new $class(
            $injector->get(ResponseHelperInterface::class),
            $injector->get(TextRepository::class),
        );
    }
}
