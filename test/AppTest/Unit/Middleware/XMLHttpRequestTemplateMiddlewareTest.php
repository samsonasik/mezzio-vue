<?php

declare(strict_types=1);

namespace AppTest\Unit\Handler;

use App\Middleware\XMLHttpRequestTemplateMiddleware;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class XMLHttpRequestTemplateMiddlewareTest extends TestCase
{
    use ProphecyTrait;

    public function testDisableLayoutOnXMLHttpRequest()
    {
        $renderer = $this->prophesize(TemplateRendererInterface::class);
        $middleware = new XMLHttpRequestTemplateMiddleware(
            $renderer->reveal()
        );

        $request = $this->prophesize(ServerRequestInterface::class);
        $request->getHeader('X-Requested-With')->willReturn(['XMLHttpRequest']);

        $handler = $this->prophesize(RequestHandlerInterface::class);
        $handler->handle($request->reveal())->willReturn(new HtmlResponse(''));

        (function ($renderer) {
            $renderer->layout = 'layout';
        })->bindTo($renderer->reveal(), $renderer->reveal())($renderer->reveal());

        $response = $middleware->process(
            $request->reveal(),
            $handler->reveal()
        );

        $this->assertFalse((function ($renderer) {
            return $renderer->layout;
        })->bindTo($renderer->reveal(), $renderer->reveal())($renderer->reveal()));
    }

    public function testEnableLayoutOnNormalHttpRequest()
    {
        $renderer = $this->prophesize(TemplateRendererInterface::class);
        $middleware = new XMLHttpRequestTemplateMiddleware(
            $renderer->reveal()
        );

        $request = $this->prophesize(ServerRequestInterface::class);
        $request->getHeader('X-Requested-With')->willReturn([]);

        $handler = $this->prophesize(RequestHandlerInterface::class);
        $handler->handle($request->reveal())->willReturn(new HtmlResponse(''));

        (function ($renderer) {
            $renderer->layout = 'layout';
        })->bindTo($renderer->reveal(), $renderer->reveal())($renderer->reveal());

        $response = $middleware->process(
            $request->reveal(),
            $handler->reveal()
        );

        $this->assertEquals(
            'layout',
            ((function ($renderer) {
                return $renderer->layout;
            })->bindTo($renderer->reveal(), $renderer->reveal())($renderer->reveal()))
        );
    }
}
