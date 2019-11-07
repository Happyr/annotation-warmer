<?php

declare(strict_types=1);

namespace Tests\Happyr\AnnotationWarmer\Resources;

class InvalidAnnotation
{
    /**
     * @FooAnnotation()
     */
    private $foo;
}
