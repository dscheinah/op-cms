<?php

namespace App\Handler;

use App\Repository\PageRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Sx\Message\Response\ResponseHelperInterface;

/**
 * Handler to load all available keys from the template and the currently selected values.
 */
class PageLoadHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ResponseHelperInterface $helper,
        private readonly PageRepository $repository,
    ) {
    }

    /**
     * Creates a JSON response from all the collected data.
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->helper->create(200, $this->repository->collect());
    }
}
