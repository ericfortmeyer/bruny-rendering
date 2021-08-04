<?php

declare(strict_types=1);

namespace Bruny\Rendering;

use Closure;

/**
 * Enables binding objects to templates.
 */
final class TemplateBinder
{
    private function __construct()
    {
    }

    /**
     * Provides a Closure that will be bound to a template.
     * 
     * After binding, the template will have access to the
     * bound object's members.
     * @see https://www.php.net/manual/en/closure.bindto#Hcom116527
     */
    public static function init(): Closure
    {
        return function (string $templateName): void {
            include $templateName;
        };
    }

    /**
     * Takes care of necessary clean up from output buffering.
     */
    public static function shutdown(): bool
    {
        return ob_end_flush();
    }
}
