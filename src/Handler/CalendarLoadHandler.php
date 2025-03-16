<?php

namespace App\Handler;

use App\Repository\CalendarRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Sx\Message\Response\ResponseHelperInterface;

class CalendarLoadHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ResponseHelperInterface $helper,
        private readonly CalendarRepository $repository,
    ) {
    }

    /**
     * Creates a JSON response from all loaded calendar entries.
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->helper->create(200, $this->repository->load());
    }
}
