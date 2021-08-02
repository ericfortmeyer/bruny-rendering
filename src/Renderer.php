<?php

declare(strict_types=1);

namespace Bruny\Rendering;

use Closure;

final class Renderer
{
    private function __construct()
    {
    }

    public static function init(): Closure
    {
        return function (string $templateName): void {
            include $templateName;
        };
    }

    public static function shutdown(): bool
    {
        return ob_end_flush();
    }
}
