<?php

namespace App\Handler;

use App\Repository\ImageRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Sx\Message\Response\ResponseHelperInterface;

/**
 * Handler to load all details for one image.
 */
class ImageLoadHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ResponseHelperInterface $helper,
        private readonly ImageRepository $repository,
    ) {
    }

    /**
     * Loads the image given by its id within the query params.
     *
     * On success the image with id, all properties and the base64 image will be returned as a JSON object.
     * The result will be 404 if no image with the given id was found.
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $image = $this->repository->load($request->getQueryParams()['id'] ?? null);
        if (!$image) {
            return $this->helper->create(404, 'Bild nicht gefunden');
        }
        return $this->helper->create(200, $image);
    }
}
