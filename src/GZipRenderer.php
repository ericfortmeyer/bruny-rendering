<?php

declare(strict_types=1);

namespace Bruny\Rendering;

use Closure;

/**
 * Sets up template rendering.
 *
 * Output is gzipped.
 * @link https://www.php.net/manual/en/function.ob-gzhandler
 *
 */
final class GzipRenderer implements RenderingInterface
{
    public function __construct(private Closure $rendererBoundToContext)
    {
        ob_start("ob_gzhandler");
    }

    /**
     * Sends the template content to the output buffer.
     *
     * {@inheritDoc}
     */
    public function render(string $template): void
    {
        $this->streamTemplate($template);
    }

    private function streamTemplate(string $templateName): void
    {
        $renderer = $this->rendererBoundToContext;
        $renderer($templateName);
    }
}
