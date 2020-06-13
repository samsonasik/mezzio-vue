<?php

declare(strict_types=1);

namespace App\Handler\Api;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PortfolioApiHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $data  = include './data/portfolio.php';
        $query = $request->getQueryParams()['keyword'] ?? '';

        $data = array_filter($data, function ($value) use ($query) {
            return $query
                && (
                    strpos(strtolower($value['title']), strtolower($query)) !== false
                    ||
                    strpos(strtolower($value['link']), strtolower($query)) !== false
                );
        });

        return new JsonResponse($data);
    }
}
