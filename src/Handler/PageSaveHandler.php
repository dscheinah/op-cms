<?php

namespace App\Handler;

use App\Repository\PageRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Sx\Message\Response\ResponseHelperInterface;

class PageSaveHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ResponseHelperInterface $helper,
        private readonly PageRepository $repository,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->repository->save((array) $request->getParsedBody());
        return $this->helper->create(204);
    }
}
