<?php

declare(strict_types=1);

namespace App\View\Helper;

use Psr\Container\ContainerInterface;

class IsDevelopmentFactory
{
    public function __invoke(ContainerInterface $container): IsDevelopment
    {
        $config = $container->get('config');
        return new IsDevelopment($config);
    }
}