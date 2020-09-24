<?php

declare(strict_types=1);

namespace AppTest\Unit\Handler;

use App\Handler\AboutPageHandler;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Message\ServerRequestInterface;

use function file_get_contents;

class AboutPageHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function testReturnsHtmlResponse()
    {
        $renderer = $this->prophesize(TemplateRendererInterface::class);
        $content  = file_get_contents('src/App/templates/app/about-page.phtml');

        $renderer
            ->render('app::about-page', ['title' => 'About Me'])
            ->willReturn($content);

        $page = new AboutPageHandler(
            $renderer->reveal()
        );

        $response = $page->handle(
            $this->prophesize(ServerRequestInterface::class)->reveal()
        );

        $this->assertInstanceOf(HtmlResponse::class, $response);
        $this->assertEquals($content, $response->getBody());
    }
}
