<?php

declare(strict_types=1);

namespace AppTest\Unit\Handler;

use App\Handler\PingHandler;
use Laminas\Diactoros\Response\JsonResponse;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Message\ServerRequestInterface;

use function json_decode;

class PingHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function testResponse()
    {
        $pingHandler = new PingHandler();
        $response    = $pingHandler->handle(
            $this->prophesize(ServerRequestInterface::class)->reveal()
        );

        $json = json_decode((string) $response->getBody(), null, 512, JSON_THROW_ON_ERROR);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertTrue(property_exists($json, 'ack') && $json->ack !== null);
    }
}
