<?php

declare(strict_types=1);

namespace AppTest\Unit\Handler;

use App\Middleware\NotFoundMiddleware;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class NotFoundMiddlewareTest extends TestCase
{
    use ProphecyTrait;

    public function testReturnsHtml404Response()
    {
        $renderer = $this->prophesize(TemplateRendererInterface::class);
        $renderer
            ->render('error::404')
            ->willReturn('');

        $middleware = new NotFoundMiddleware(
            $renderer->reveal(),
            [
                'mezzio' => [
                    'error_handler' => [
                        'template_404'   => 'error::404',
                    ],
                ],
            ]
        );

        $response = $middleware->process(
            $this->prophesize(ServerRequestInterface::class)->reveal(),
            $this->prophesize(RequestHandlerInterface::class)->reveal()
        );

        $this->assertInstanceOf(HtmlResponse::class, $response);
    }
}
