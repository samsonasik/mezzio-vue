<?php

declare(strict_types=1);

namespace AppTest\Unit\Handler\Api;

use App\Handler\Api\PortfolioApiHandler;
use Laminas\Diactoros\Response\JsonResponse;
use PHPUnit\Framework\Attributes\DataProvider;
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

    #[DataProvider('keywordProvider')]
    public function testResponseSearchByKeyword(mixed $keyword, int $totalResult): void
    {
        $this->request->getQueryParams()->willReturn([
            'keyword' => $keyword,
        ]);
        $response = $this->handler->handle(
            $this->request->reveal()
        );

        $jsonDecoded = json_decode((string) $response->getBody(), null, 512, JSON_THROW_ON_ERROR);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertCount($totalResult, $jsonDecoded);
    }

    public static function keywordProvider(): array
    {
        return [
            ['', 3],
            ['0', 3],
            ['website a', 1],
            [[], 3],
        ];
    }
}
