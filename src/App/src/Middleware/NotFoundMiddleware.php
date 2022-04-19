<?php

declare(strict_types=1);

namespace App\Middleware;

use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class NotFoundMiddleware implements MiddlewareInterface
{
    private TemplateRendererInterface $template;
    private array $config;

    /**
     * @param mixed[] $config
     */
    public function __construct(TemplateRendererInterface $template, array $config)
    {
        $this->template = $template;
        $this->config   = $config;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return new HtmlResponse(
            $this->template->render($this->config['mezzio']['error_handler']['template_404'])
        );
    }
}
