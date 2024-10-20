<?php

declare(strict_types=1);

namespace App\Middleware;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function in_array;

class XMLHttpRequestTemplateMiddleware implements MiddlewareInterface
{
    public function __construct(private readonly TemplateRendererInterface $template)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (in_array('XMLHttpRequest', $request->getHeader('X-Requested-With'), true)) {
            (function ($template): void {
                $template->layout = null;
            })->bindTo($this->template, $this->template)($this->template);
        }

        return $handler->handle($request);
    }
}
