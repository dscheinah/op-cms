<?php

namespace App;

use App\Handler\CalendarLoadHandler;
use App\Handler\CalendarRemoveHandler;
use App\Handler\CalendarSaveHandler;
use App\Handler\PageLoadHandler;
use App\Handler\PageSaveHandler;
use App\Handler\TextListHandler;
use App\Handler\TextLoadHandler;
use App\Handler\TextRemoveHandler;
use App\Handler\TextSaveHandler;
use Sx\Container\FactoryInterface;
use Sx\Container\Injector;
use Sx\Server\MiddlewareHandlerInterface;
use Sx\Server\Router;

/**
 * The factory for the router. It defines all available routes.
 */
class RouterFactory implements FactoryInterface
{
    /**
     * Creates the router and registers all handlers for routes.
     *
     * @param Injector $injector
     * @param array    $options
     * @param string   $class
     *
     * @return Router
     */
    public function create(Injector $injector, array $options, string $class): Router
    {
        // The prefix can be set in the config if the index.php is not available from "/".
        $prefix = $options['prefix'] ?? '';
        $router = new Router($injector->get(MiddlewareHandlerInterface::class));

        $router->get($prefix . 'page/load', PageLoadHandler::class);
        $router->post($prefix . 'page/save', PageSaveHandler::class);

        $router->get($prefix . 'text/list', TextListHandler::class);
        $router->get($prefix . 'text/load', TextLoadHandler::class);
        $router->post($prefix . 'text/save', TextSaveHandler::class);
        $router->delete($prefix . 'text/remove', TextRemoveHandler::class);

        $router->get($prefix . 'calendar/load', CalendarLoadHandler::class);
        $router->post($prefix . 'calendar/save', CalendarSaveHandler::class);
        $router->delete($prefix . 'calendar/remove', CalendarRemoveHandler::class);

        return $router;
    }
}
