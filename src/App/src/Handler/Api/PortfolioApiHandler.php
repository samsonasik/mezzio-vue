<?php

declare(strict_types=1);

namespace App\Handler\Api;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function array_filter;
use function stripos;

class PortfolioApiHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data    = include './data/portfolio.php';
        $keyword = $request->getQueryParams()['keyword'] ?? '';

        if ($keyword) {
            $data = array_filter($data, function ($value) use ($keyword) {
                return stripos($value['title'], $keyword) !== false
                    ||
                    stripos($value['link'], $keyword) !== false;
            });
        }

        return new JsonResponse($data);
    }
}
