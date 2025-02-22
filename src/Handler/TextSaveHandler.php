<?php

namespace App\Handler;

use App\Repository\TextRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Sx\Message\Response\ResponseHelperInterface;

/**
 * Handler to create or update a text.
 */
class TextSaveHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ResponseHelperInterface $helper,
        private readonly TextRepository $repository,
    ) {
    }

    /**
     * Saves the given POST-data as text.
     *
     * Example data:
     * id=42&&name=Name&content=Text-Content
     *
     * If no id is given, a new text will be inserted.
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
