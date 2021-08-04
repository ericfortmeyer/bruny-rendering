<?php

declare(strict_types=1);

namespace Bruny\Rendering;

/**
 * Sets up template rendering by binding a template to an object.
 * 
 * Output is gzipped.
 * @see https://www.php.net/manual/en/function.ob-gzhandler
 * 
 */
final class TemplateRegistry
{
    private array $registeredTemplates = [];

    public function __construct(private $pathToTemplates, array $templateConfig)
    {
        array_walk($templateConfig, [$this, "register"]);
    }

    function add(string $pathToTemplate, string $templateName)
    {
        $this->registeredTemplates[$templateName] = $pathToTemplate;
    }

    public function get(string $templateName): string
    {
        return $this->pathToTemplates . DIRECTORY_SEPARATOR . $this->registeredTemplates[$templateName];
    }
}
