<?php

declare(strict_types=1);

namespace AppTest\Unit\Handler;

use App\Handler\AboutPageHandler;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Message\ServerRequestInterface;

use function ob_get_clean;
use function ob_start;

class AboutPageHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function testReturnsHtmlResponse()
    {
        $renderer = $this->prophesize(TemplateRendererInterface::class);

        ob_start();
        require_once 'src/App/templates/app/about-page.phtml';
        $content = ob_get_clean();

        $renderer
            ->render('app::about-page')
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
