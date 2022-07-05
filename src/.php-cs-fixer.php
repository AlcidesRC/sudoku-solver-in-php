<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->ignoreDotFiles(true)
    ->exclude([
        './vendor/',
        './coverage/',
        './metrics/',
    ])
    ->name('.php-cs-fixer.php')
;

$config = new PhpCsFixer\Config();
return $config->setRules([
        '@PSR12' => true,
        '@PHP81Migration' => true,
        '@PHP80Migration:risky' => false,
        'array_indentation' => true,
        'declare_equal_normalize' => true,
        'full_opening_tag' => false,
        'function_typehint_space' => true,
        'heredoc_indentation' => false,
        'include' => true,
        'lowercase_cast' => true,
        'multiline_whitespace_before_semicolons' => true,
        'no_multiline_whitespace_around_double_arrow' => true,
        'no_spaces_around_offset' => true,
        'no_spaces_inside_parenthesis' => true,
        'no_trailing_comma_in_list_call' => false,
        'no_trailing_comma_in_singleline_array' => false,
        'no_trailing_whitespace' => true,
        'no_unneeded_control_parentheses' => true,
        'no_unused_imports' => true,
        'no_whitespace_before_comma_in_array' => true,
        'no_whitespace_in_blank_line' => true,
        'not_operator_with_space' => false,
        'object_operator_without_whitespace' => true,
        'ordered_class_elements' => true,
        'ordered_imports' => true,
        'single_line_comment_style' => true,
        'single_quote' => false,
        'switch_case_space' => false,
        'ternary_operator_spaces' => true,
        'trim_array_spaces' => true,
        'unary_operator_spaces' => true,
        'whitespace_after_comma_in_array' => true,
    ])
    ->setFinder($finder)
;
