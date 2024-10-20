<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PortfolioPageHandler implements RequestHandlerInterface
{
    public function __construct(private readonly TemplateRendererInterface $template)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse($this->template->render('app::portfolio-page'));
    }
}
