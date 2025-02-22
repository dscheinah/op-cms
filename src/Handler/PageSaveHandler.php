<?php

namespace App\Handler;

use App\Repository\PageRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Sx\Message\Response\ResponseHelperInterface;

/**
 * Handler to update the current selection for each template key.
 */
class PageSaveHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ResponseHelperInterface $helper,
        private readonly PageRepository $repository,
    ) {
    }

    /**
     * Saves all selections and returns 204 on success.
     *
     * POST-data is assumed to be of the form: type[key]=value
     * e.g. text[introduction]=42&image[main]=23
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
