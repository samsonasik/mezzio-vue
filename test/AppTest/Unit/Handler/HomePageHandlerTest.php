<?php

declare(strict_types=1);

namespace AppTest\Unit\Handler;

use App\Handler\HomePageHandler;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Message\ServerRequestInterface;

use function file_get_contents;

class HomePageHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function testReturnsHtmlResponse(): void
    {
        $renderer = $this->prophesize(TemplateRendererInterface::class);
        $content  = file_get_contents('src/App/templates/app/home-page.phtml');

        $renderer
            ->render('app::home-page', Argument::type('array'))
            ->willReturn($content);

        $homePage = new HomePageHandler(
            $renderer->reveal()
        );

        $response = $homePage->handle(
            $this->prophesize(ServerRequestInterface::class)->reveal()
        );

        $this->assertInstanceOf(HtmlResponse::class, $response);
        $this->assertEquals($content, $response->getBody());
    }
}
