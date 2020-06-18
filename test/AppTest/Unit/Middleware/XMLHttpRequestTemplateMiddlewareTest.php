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

    private $renderer;
    private $middleware;
    private $request;
    private $handler;

    protected function setUp(): void
    {
        $this->renderer = $this->prophesize(TemplateRendererInterface::class);
        (function ($renderer) {
            $renderer->layout = 'layout';
        })->bindTo($this->renderer->reveal(), $this->renderer->reveal())($this->renderer->reveal());

        $this->middleware = new XMLHttpRequestTemplateMiddleware(
            $this->renderer->reveal()
        );

        $this->request = $this->prophesize(ServerRequestInterface::class);
        $this->handler = $this->prophesize(RequestHandlerInterface::class);
        $this->handler->handle($this->request->reveal())->willReturn(new HtmlResponse(''));
    }

    public function testDisableLayoutOnXMLHttpRequest()
    {
        $this->request->getHeader('X-Requested-With')->willReturn(['XMLHttpRequest']);

        $response = $this->middleware->process(
            $this->request->reveal(),
            $this->handler->reveal()
        );

        $this->assertFalse((function ($renderer) {
            return $renderer->layout;
        })->bindTo($this->renderer->reveal(), $this->renderer->reveal())($this->renderer->reveal()));
    }

    public function testEnableLayoutOnNormalHttpRequest()
    {
        $this->request->getHeader('X-Requested-With')->willReturn([]);

        $response = $this->middleware->process(
            $this->request->reveal(),
            $this->handler->reveal()
        );

        $this->assertEquals(
            'layout',
            (function ($renderer) {
                return $renderer->layout;
            })->bindTo($this->renderer->reveal(), $this->renderer->reveal())($this->renderer->reveal())
        );
    }
}
