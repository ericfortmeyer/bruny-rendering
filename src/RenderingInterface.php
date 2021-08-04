<?php

declare(strict_types=1);

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