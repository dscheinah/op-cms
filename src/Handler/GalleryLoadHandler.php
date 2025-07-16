<?php

namespace App\Handler;

use App\Repository\GalleryRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Sx\Message\Response\ResponseHelperInterface;

/**
 * Handler to load all details for one gallery.
 */
class GalleryLoadHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ResponseHelperInterface $helper,
        private readonly GalleryRepository $repository,
    ) {
    }

    /**
     * Loads the gallery given by its id within the query params.
     *
     * On success the gallery with id, name and assigned images will be returned as a JSON object.
     * The result will be 404 if no gallery with the given id was found.
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $gallery = $this->repository->load($request->getQueryParams()['id'] ?? null);
        if (!$gallery) {
            return $this->helper->create(404, 'Sammlung nicht gefunden');
        }
        return $this->helper->create(200, $gallery);
    }
}
