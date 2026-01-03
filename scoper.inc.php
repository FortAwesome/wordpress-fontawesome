<?php

declare(strict_types=1);

use Isolated\Symfony\Component\Finder\Finder;

$vendor_dir = getenv('COMPOSER_VENDOR_DIR') ?? 'vendor';

return [
    'prefix' => 'FontAwesomeDeps',
    'finders' => [
        Finder::create()
        	->files()
         ->ignoreVCS(true)
         ->name('*.php')
         ->notName('/LICENSE|.*\\.md|.*\\.dist|Makefile|composer\\.json|composer\\.lock/')
         ->exclude([
             'doc',
             'test',
             'test_old',
             'tests',
             'Tests',
             'vendor-bin',
             'build'
         ])
         ->in($vendor_dir . '/fortawesome/wordpress-fontawesome-lib')
    ]
];
