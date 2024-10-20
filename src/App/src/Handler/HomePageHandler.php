<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class HomePageHandler implements RequestHandlerInterface
{
    public function __construct(private readonly TemplateRendererInterface $template)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = [];

        $data['containerName'] = 'Laminas Servicemanager';
        $data['containerDocs'] = 'https://docs.laminas.dev/laminas-servicemanager/';

        $data['routerName'] = 'Laminas Router';
        $data['routerDocs'] = 'https://docs.laminas.dev/laminas-router/';

        $data['templateName'] = 'Laminas View';
        $data['templateDocs'] = 'https://docs.laminas.dev/laminas-view/';

        return new HtmlResponse($this->template->render('app::home-page', $data));
    }
}
