<?php

namespace App\Handler;

use App\Repository\ImageRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Sx\Message\Response\ResponseHelperInterface;

/**
 * Handler to create or update an image.
 */
class ImageSaveHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ResponseHelperInterface $helper,
        private readonly ImageRepository $repository,
    ) {
    }

    /**
     * Saves the given POST-data as image.
     *
     * If no id is given, a new image will be inserted.
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $parsedBody = (array) $request->getParsedBody();
        if (isset($parsedBody['id'])) {
            $this->repository->saveOnlyData($parsedBody);
        } else {
            $upload = $request->getUploadedFiles()['file'] ?? null;
            if (!$upload || $upload->getError() !== UPLOAD_ERR_OK) {
                return $this->helper->create(400, 'Upload fehlgeschlagen');
            }
            $this->repository->saveWithUpload($parsedBody, $upload);
        }
        return $this->helper->create(204);
    }
}
