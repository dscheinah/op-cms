<?php

namespace App\Handler;

use App\Repository\ImageRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Sx\Message\Response\ResponseHelperInterface;

/**
 * Handler to load all available images.
 */
class ImageListHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ResponseHelperInterface $helper,
        private readonly ImageRepository $repository,
    ) {
    }

    /**
     * Output all images as an array of objects with id, name, and base64 thumbnail in alphabetical order.
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->helper->create(200, $this->repository->list($request->getQueryParams()['gallery'] ?? null));
    }
}
