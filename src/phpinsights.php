<?php

declare(strict_types=1);

return [
    'preset' => 'default',

    'ide' => 'sublime',

    'add' => [
        \NunoMaduro\PhpInsights\Domain\Metrics\Code\Comments::class => [
            \SlevomatCodingStandard\Sniffs\Namespaces\FullyQualifiedClassNameInAnnotationSniff::class,
        ],
    ],

    'exclude' => [
        './.cache/',
        './.logs/',
        './.reports/',
        './phpinsights.php',
        './vendor',
    ],

    'config' => [
        \PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff::class => [
            'lineLimit'         => 120,
            'absoluteLineLimit' => 160,
        ],
        \PhpCsFixer\Fixer\Import\OrderedImportsFixer::class => [
            'imports_order' => [
                'class',
                'const',
                'function',
            ],
            'sort_algorithm' => 'alpha',
        ],
        \PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer::class => [
            'operators' => [
                '=>' => 'align_single_space_minimal',
            ],
        ],
        \PhpCsFixer\Fixer\Whitespace\NoExtraBlankLinesFixer::class => [
            'tokens' => [
                'break',
                'case',
                'continue',
                'curly_brace_block',
                'default',
                'extra',
                'parenthesis_brace_block',
                'return',
                'square_brace_block',
                'switch',
                'throw',
                'use',
            ],
        ],
    ],

    'threads' => 4,
];
