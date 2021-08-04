<?php

declare(strict_types=1);

namespace Bruny\Rendering;

/**
 * Exposes the render method for implementations
 */
interface RenderingInterface
{
    /**
     * Display a given template.
     */
    public function render(string $template): void;
}
