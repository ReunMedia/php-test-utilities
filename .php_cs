<?php
/**
 * Reun Media PHP CS Fixer configuration file.
 *
 * @author Kimmo Salmela <kimmo.salmela@reun.eu>
 * @copyright 2020 Reun Media
 *
 * @see https://gitlab.com/reun/webdev/generator-reun-webapp
 *
 * @version 1.0.0
 */

declare(strict_types=1);

return PhpCsFixer\Config::create()
  ->setRiskyAllowed(true)
  ->setIndent('  ')
  ->setRules([
    '@PhpCsFixer' => true,
    '@PSR2' => true,
    'declare_strict_types' => true,
    'single_line_comment_style' => false,
    'single_quote' => false,
    'ordered_class_elements' => false,
  ])
;
