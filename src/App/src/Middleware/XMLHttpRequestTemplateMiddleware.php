<?php

declare(strict_types=1);

namespace App\Middleware;

use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Handler\NotFoundHandler;
use Mezzio\Router\RouteResult;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class XMLHttpRequestTemplateMiddleware implements MiddlewareInterface
{
    private $notFoundHandler;
    private $template;

    public function __construct(NotFoundHandler $notFoundHandler, TemplateRendererInterface $template)
    {
        $this->notFoundHandler = $notFoundHandler;
        $this->template        = $template;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        if (in_array('XMLHttpRequest', $request->getHeader('X-Requested-With'), true)) {
            (function ($template) {
                $template->layout = false;
            })->bindTo($this->template, $this->template)($this->template);
        }

        $routeResult    = $request->getAttribute(RouteResult::class);
        if ($routeResult->isFailure()) {
            return new HtmlResponse($this->template->render('error::404'));
        }

        return $handler->handle($request);
    }
}