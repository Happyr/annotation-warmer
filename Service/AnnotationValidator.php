<?php

declare(strict_types=1);

namespace Happyr\AnnotationWarmer\Service;

use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Annotations\Reader;

/**
 *
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class AnnotationValidator
{
    private $reader;

    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * @returns AnnotationException[]
     */
    public function validateClasses(array $classes): array
    {
        $exceptions = [];
        foreach ($classes as $class) {
            try {
                $this->validateClass($class);
            } catch (AnnotationException $e) {
                $exceptions[] = $e;
            }
        }

        return $exceptions;
    }

    private function validateClass($class)
    {
        $reflectionClass = new \ReflectionClass($class);
        $this->reader->getClassAnnotations($reflectionClass);

        foreach ($reflectionClass->getMethods() as $reflectionMethod) {
            $this->reader->getMethodAnnotations($reflectionMethod);
        }

        foreach ($reflectionClass->getProperties() as $reflectionProperty) {
            $this->reader->getPropertyAnnotations($reflectionProperty);
        }
    }
}
