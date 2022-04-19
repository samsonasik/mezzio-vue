<?php

declare(strict_types=1);

namespace AppTest\Unit\Handler;

use App\Middleware\XMLHttpRequestTemplateMiddleware;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class XMLHttpRequestTemplateMiddlewareTest extends TestCase
{
    use ProphecyTrait;

    private ObjectProphecy $renderer;
    private XMLHttpRequestTemplateMiddleware $middleware;
    private ObjectProphecy $request;
    private ObjectProphecy $handler;

    protected function setUp(): void
    {
        $this->renderer = $this->prophesize(TemplateRendererInterface::class);
        (function ($renderer): void {
            $renderer->layout = 'layout';
        })->bindTo($this->renderer->reveal(), $this->renderer->reveal())($this->renderer->reveal());

        $this->middleware = new XMLHttpRequestTemplateMiddleware(
            $this->renderer->reveal()
        );

        $this->request = $this->prophesize(ServerRequestInterface::class);
        $this->handler = $this->prophesize(RequestHandlerInterface::class);
        $this->handler->handle($this->request->reveal())->willReturn(new HtmlResponse(''));
    }

    public function testDisableLayoutOnXMLHttpRequest(): void
    {
        $this->request->getHeader('X-Requested-With')->willReturn(['XMLHttpRequest']);

        $this->middleware->process(
            $this->request->reveal(),
            $this->handler->reveal()
        );

        $this->assertFalse(
            (fn($renderer) => $renderer->layout)->bindTo(
                $this->renderer->reveal(),
                $this->renderer->reveal()
            )($this->renderer->reveal())
        );
    }

    public function testEnableLayoutOnNormalHttpRequest(): void
    {
        $this->request->getHeader('X-Requested-With')->willReturn([]);

        $this->middleware->process(
            $this->request->reveal(),
            $this->handler->reveal()
        );

        $this->assertEquals(
            'layout',
            (fn($renderer) => $renderer->layout)->bindTo(
                $this->renderer->reveal(),
                $this->renderer->reveal()
            )($this->renderer->reveal())
        );
    }
}
