<?php

namespace App\Handler;

use App\Repository\TextRepository;
use Sx\Container\FactoryInterface;
use Sx\Container\Injector;
use Sx\Message\Response\ResponseHelperInterface;

/**
 * Common Factory for all Text*Handler implementations.
 */
class TextHandlerFactory implements FactoryInterface
{
    /**
     * Creates the handler with a response helper (to create JSON responses) and with access to the domain repository.
     *
     * @param Injector $injector
     * @param array $options
     * @param string $class
     *
     * @return mixed
     */
    public function create(Injector $injector, array $options, string $class): object
    {
        return new $class(
            $injector->get(ResponseHelperInterface::class),
            $injector->get(TextRepository::class),
        );
    }
}
