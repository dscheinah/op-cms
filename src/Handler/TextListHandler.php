<?php

namespace App\Handler;

use App\Repository\TextRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Sx\Message\Response\ResponseHelperInterface;

/**
 * Handler to load all available texts.
 */
class TextListHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ResponseHelperInterface $helper,
        private readonly TextRepository $repository,
    ) {
    }

    /**
     * Output all texts as an array of objects with id and name in alphabetical order.
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->helper->create(200, $this->repository->list());
    }
}
