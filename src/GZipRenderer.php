<?php

declare(strict_types=1);

namespace Bruny\Rendering;

use Closure;
use RenderingInterface;

/**
 * Sets up template rendering.
 * 
 * Output is gzipped.
 * @link https://www.php.net/manual/en/function.ob-gzhandler
 * 
 */
final class GzipRenderer implements RenderingInterface
{
    public function __construct(private Closure|false $rendererBoundToContext)
    {
        ob_start("ob_gzhandler");
    }

    /**
     * Sends the template content to the output buffer.
     * 
     * {@inheritDoc}
     */
    public function render(string $template, ?object $context = null): void
    {
        is_null($context)
            ? $this->streamTemplateWithoutContext($template)
            : $this->streamTemplateWithContext($template, HTMLEncoder::safelyPrepareData($context));
    }

    private function streamTemplateWithContext(string $templateName): void
    {
        $rendererBoundToContext = $this->rendererBoundToContext;
        $rendererBoundToContext($templateName);
    }

    private function streamTemplateWithoutContext(string $templateName): void
    {
        $renderer = $this->renderer;
        $renderer($templateName);
    }
}
