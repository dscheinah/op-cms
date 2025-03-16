<?php

namespace App\Handler;

use App\Repository\CalendarRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Sx\Message\Response\ResponseHelperInterface;

class CalendarRemoveHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ResponseHelperInterface $helper,
        private readonly CalendarRepository $repository,
    ) {
    }

    /**
     * Deletes the calendar entry given by its id within the query params.
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->repository->remove($request->getQueryParams()['id'] ?? null);
        return $this->helper->create(204);
    }
}
