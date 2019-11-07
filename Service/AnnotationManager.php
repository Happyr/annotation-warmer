<?php

declare(strict_types=1);

namespace Happyr\AnnotationWarmer\Service;

class AnnotationManager
{
    private $classes;

    public function __construct(array $classes)
    {
        $this->classes = $classes;
    }

    public function getAllClasses(): array
    {
        return $this->classes;
    }
}
