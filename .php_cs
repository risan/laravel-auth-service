<?php

use Symfony\CS\Config\Config;
use Symfony\CS\FixerInterface;
use Symfony\CS\Finder\DefaultFinder;

$finder = DefaultFinder::create()
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/config');

$fixers = [
    'alias_functions',
    'align_double_arrow',
    'array_element_no_space_before_comma',
    'array_element_white_space_after_comma',
    'blankline_after_open_tag',
    'braces',
    'class_definition',
    'concat_without_spaces',
    'double_arrow_multiline_whitespaces',
    'duplicate_semicolon',
    'elseif',
    'empty_return',
    'encoding',
    'eof_ending',
    'extra_empty_lines',
    'function_call_space',
    'function_declaration',
    'function_typehint_space',
    'hash_to_slash_comment',
    'include',
    'indentation',
    'linefeed',
    'line_after_namespace',
    'list_commas',
    'lowercase_constants',
    'lowercase_keywords',
    'method_argument_default_value',
    'method_argument_space',
    'method_separation',
    'multiline_array_trailing_comma',
    'multiline_spaces_before_semicolon',
    'multiple_use',
    'namespace_no_leading_whitespace',
    'new_with_braces',
    'no_blank_lines_after_class_opening',
    'no_empty_lines_after_phpdocs',
    'object_operator',
    'operators_spaces',
    'ordered_use',
    'parenthesis',
    'phpdoc_align',
    'phpdoc_indent',
    'phpdoc_inline_tag',
    'phpdoc_no_access',
    'phpdoc_no_package',
    'phpdoc_order',
    'phpdoc_scalar',
    'phpdoc_separation',
    'phpdoc_summary',
    'phpdoc_to_comment',
    'phpdoc_trim',
    'phpdoc_type_to_var',
    'phpdoc_types',
    'phpdoc_var_without_name',
    'php_closing_tag',
    'print_to_echo',
    'psr4',
    'remove_leading_slash_use',
    'remove_lines_between_uses',
    'return',
    'self_accessor',
    'short_array_syntax',
    'short_bool_cast',
    'short_tag',
    'single_array_no_trailing_comma',
    'single_blank_line_before_namespace',
    'single_line_after_imports',
    'single_quote',
    'spaces_after_semicolon',
    'spaces_before_semicolon',
    'spaces_cast',
    'standardize_not_equal',
    'switch_case_space',
    'ternary_spaces',
    'trailing_spaces',
    'trim_array_spaces',
    'unalign_equals',
    'unary_operators_spaces',
    'unneeded_control_parentheses',
    'unused_use',
    'visibility',
    'whitespacy_lines',
];

return Config::create()
    ->finder($finder)
    ->fixers($fixers)
    ->level(FixerInterface::NONE_LEVEL)
    ->setUsingCache(true);
