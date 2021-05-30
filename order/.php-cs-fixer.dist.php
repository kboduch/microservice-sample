<?php

$finder = (new PhpCsFixer\Finder())
    ->in(['src', 'lib'])
    ->exclude(['var', 'vendor']);

return (new PhpCsFixer\Config())
    ->setRules(
        [
            '@PhpCsFixer:risky' => true,
            'declare_strict_types' => true,
        ]
    )
    ->setFinder($finder);
