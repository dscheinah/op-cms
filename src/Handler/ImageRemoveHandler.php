<?php

namespace App\Handler;

use App\Repository\ImageRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Sx\Message\Response\ResponseHelperInterface;

/**
 * Handler to delete one image.
 */
class ImageRemoveHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ResponseHelperInterface $helper,
        private readonly ImageRepository $repository,
    ) {
    }

    /**
     * Deletes the image given by its id within the query params.
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
