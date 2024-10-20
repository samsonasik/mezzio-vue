<?php

declare(strict_types=1);

namespace App\View\Helper;

use Laminas\View\Helper\AbstractHelper;

class IsDevelopment extends AbstractHelper
{
    /**
     * @param mixed[] $config
     */
    public function __construct(private array $config)
    {
    }

    public function __invoke(): bool
    {
        return $this->config['debug'] ?? false;
    }
}
