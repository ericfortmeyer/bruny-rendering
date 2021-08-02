<?php

declare(strict_types=1);

namespace ScratchPHP\Rendering;

use Closure;

final class Engine
{
    private array $registeredTemplates = [];

    public function __construct(private Closure $renderer, private $pathToTemplates, array $templateConfig)
    {
        ob_start("ob_gzhandler");
        array_walk($templateConfig, [$this, "register"]);
    }

    private function register(string $pathToTemplate, string $templateName)
    {
        $this->registeredTemplates[$templateName] = $pathToTemplate;
    }

    public function render(string $templateName, ?object $context = null): void
    {
        $template = $this->getTemplate($templateName);
        is_null($context)
            ? $this->streamTemplateWithoutContext($template)
            : $this->streamTemplateWithContext($template, HTMLEncoder::safelyPrepareData($context));
    }

    private function getTemplate(string $templateName): string
    {
        return $this->pathToTemplates . DIRECTORY_SEPARATOR . $this->registeredTemplates[$templateName];
    }

    private function streamTemplateWithContext(string $templateName, object $context): void
    {
        $rendererBoundToContext = $this->renderer->bindTo($context, $context);
        $rendererBoundToContext($templateName);
    }

    private function streamTemplateWithoutContext(string $templateName): void
    {
        $renderer = $this->renderer;
        $renderer($templateName);
    }
}
