<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Include_\AbsolutizeRequireAndIncludePathRector;
use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/test',
    ])
    ->withRootFiles()
    ->withSkip([
        __DIR__ . '/src/App/templates',
        AbsolutizeRequireAndIncludePathRector::class,
    ])
    ->withImportNames(removeUnusedImports: true)
    ->withPhpSets(php81: true)
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        typeDeclarations: true,
    );
