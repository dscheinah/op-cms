<?php

namespace App\Handler;

use App\Repository\TextRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Sx\Message\Response\ResponseHelperInterface;

class TextLoadHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ResponseHelperInterface $helper,
        private readonly TextRepository $repository,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $text = $this->repository->load($request->getQueryParams()['id'] ?? null);
        if (!$text) {
            return $this->helper->create(404, 'Text nicht gefunden');
        }
        return $this->helper->create(200, $text);
    }
}
