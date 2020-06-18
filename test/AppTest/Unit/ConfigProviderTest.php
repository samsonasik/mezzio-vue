<?php

declare(strict_types=1);

namespace AppTest\Unit;

use App\ConfigProvider;
use PHPUnit\Framework\TestCase;

class ConfigProviderTest extends TestCase
{
    private $configProvider;

    protected function setUp(): void
    {
        $this->configProvider = new ConfigProvider();
    }

    public function testInvoke()
    {
        $this->assertIsArray(($this->configProvider)());
    }
}
