<?php

declare(strict_types=1);

namespace App\Handler\Api;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function array_filter;
use function is_string;
use function stripos;

class PortfolioApiHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var array<int, array<string, string>> $data */
        $data    = include './data/portfolio.php';
        $keyword = $request->getQueryParams()['keyword'] ?? '';

        if (is_string($keyword) && $keyword !== '' && $keyword !== '0') {
            $data = array_filter(
                $data,
                static fn (array $value): bool
                    => stripos($value['title'], $keyword) !== false || stripos($value['link'], $keyword) !== false
            );
        }

        return new JsonResponse($data);
    }
}
