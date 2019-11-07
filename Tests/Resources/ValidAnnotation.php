<?php

declare(strict_types=1);

namespace Tests\Happyr\AnnotationWarmer\Resources;

use Tests\Happyr\AnnotationWarmer\Resources\Annotation\FooAnnotation;

class ValidAnnotation
{
    /**
     * @FooAnnotation()
     */
    private $foo;
}
