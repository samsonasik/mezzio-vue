<?php

declare(strict_types=1);

namespace App\View\Helper;

use Laminas\View\Helper\AbstractHelper;

class IsDevelopment extends AbstractHelper
{
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function __invoke(): bool
    {
        return $this->config['debug'] ?? false;
    }
}
