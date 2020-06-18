<?php

declare(strict_types=1);

namespace AppTest\Unit\Handler\Api;

use App\Handler\Api\PortfolioApiHandler;
use function json_decode;
use Laminas\Diactoros\Response\JsonResponse;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

use Psr\Http\Message\ServerRequestInterface;

class PortfolioApiHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function testResponseNotSearchByKeyword()
    {
        $pingHandler = new PortfolioApiHandler();
        $response = $pingHandler->handle(
            $this->prophesize(ServerRequestInterface::class)->reveal()
        );

        $jsonDecoded = json_decode((string) $response->getBody());

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertCount(3, $jsonDecoded);
    }

    public function testResponseSearchByKeyword()
    {
        $pingHandler = new PortfolioApiHandler();
        $request     = $this->prophesize(ServerRequestInterface::class);
        $request->getQueryParams()->willReturn([
            'keyword' => 'website a'
        ]);
        $response = $pingHandler->handle(
            $request->reveal()
        );

        $jsonDecoded = json_decode((string) $response->getBody());

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertCount(1, $jsonDecoded);
    }
}
