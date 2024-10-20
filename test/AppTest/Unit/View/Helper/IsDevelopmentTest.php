<?php

declare(strict_types=1);

namespace AppTest\Unit\View\Helper;

use App\View\Helper\IsDevelopment;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class IsDevelopmentTest extends TestCase
{
    /**
     * @return array<string, mixed[]>
     */
    public static function provideConfig(): array
    {
        return [
            'non empty falsy debug config' => [['debug' => false]],
            'empty config'                 => [[]],
        ];
    }

    /**
     * @param mixed[]|array<string, true> $config
     */
    #[DataProvider('provideConfig')]
    public function testIsNotDevelopment(array $config): void
    {
        $helper = new IsDevelopment($config);
        $this->assertFalse($helper());
    }

    public function testIsDevelopment(): void
    {
        $helper = new IsDevelopment(['debug' => true]);
        $this->assertTrue($helper());
    }
}
