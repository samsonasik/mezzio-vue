<?php

declare(strict_types=1);

namespace AppTest\Unit\Handler\Api;

use App\Handler\Api\PortfolioApiHandler;
use Laminas\Diactoros\Response\JsonResponse;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ServerRequestInterface;

use function json_decode;

use const JSON_THROW_ON_ERROR;

class PortfolioApiHandlerTest extends TestCase
{
    use ProphecyTrait;

    private PortfolioApiHandler $handler;
    private ObjectProphecy $request;

    protected function setUp(): void
    {
        $this->handler = new PortfolioApiHandler();
        $this->request = $this->prophesize(ServerRequestInterface::class);
    }

    public function testResponseNotSearchByKeyword(): void
    {
        $response = $this->handler->handle(
            $this->request->reveal()
        );

        $jsonDecoded = json_decode((string) $response->getBody(), null, 512, JSON_THROW_ON_ERROR);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertCount(3, $jsonDecoded);
    }

    public function testResponseSearchByKeyword(): void
    {
        $this->request->getQueryParams()->willReturn([
            'keyword' => 'website a',
        ]);
        $response = $this->handler->handle(
            $this->request->reveal()
        );

        $jsonDecoded = json_decode((string) $response->getBody(), null, 512, JSON_THROW_ON_ERROR);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertCount(1, $jsonDecoded);
    }
}
