<?php

namespace App\Handler;

use App\Repository\TextRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Sx\Message\Response\ResponseHelperInterface;

/**
 * Handler to load all details for one text.
 */
class TextLoadHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ResponseHelperInterface $helper,
        private readonly TextRepository $repository,
    ) {
    }

    /**
     * Loads the text given by its id within the query params.
     *
     * On success the text with id, name and content will be returned as a JSON object.
     * The result will be 404 if no text with the given id was found.
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $text = $this->repository->load($request->getQueryParams()['id'] ?? null);
        if (!$text) {
            return $this->helper->create(404, 'Text nicht gefunden');
        }
        return $this->helper->create(200, $text);
    }
}
