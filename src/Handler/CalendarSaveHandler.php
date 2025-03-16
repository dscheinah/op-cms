<?php

namespace App\Handler;

use App\Repository\CalendarRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Sx\Message\Response\ResponseHelperInterface;

class CalendarSaveHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ResponseHelperInterface $helper,
        private readonly CalendarRepository $repository,
    ) {
    }

    /**
     * Saves the given POST-data as calendar entry.
     *
     * Example data:
     * id=42&&date=2025-12-24&time=23:42:00&place=Place&title=Title&description=Description&link=https://link
     *
     * If no id is given, a new entry will be inserted.
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->repository->save((array) $request->getParsedBody());
        return $this->helper->create(204);
    }
}
