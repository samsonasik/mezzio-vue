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
        $keyword = $request->getQueryParams()['keyword'] ?? '';

        if ($keyword) {
            $keyword = strtolower($keyword);
            $data = array_filter($data, function ($value) use ($keyword) {
                return (
                    strpos(strtolower($value['title']), $keyword) !== false
                    ||
                    strpos(strtolower($value['link']), $keyword) !== false
                );
            });
        }

        return new JsonResponse($data);
    }
}
