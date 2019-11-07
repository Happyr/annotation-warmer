<?php

declare(strict_types=1);

namespace Tests\Happyr\AnnotationWarmer\Service;

use Doctrine\Common\Annotations\AnnotationReader;
use Happyr\AnnotationWarmer\Service\AnnotationValidator;
use PHPUnit\Framework\TestCase;
use Tests\Happyr\AnnotationWarmer\Resources\InvalidAnnotation;
use Tests\Happyr\AnnotationWarmer\Resources\ValidAnnotation;

/**
 * @internal
 */
final class AnnotationValidatorTest extends TestCase
{
    public function testValidateClasses()
    {
        $validator = new AnnotationValidator(new AnnotationReader());
        $output = $validator->validateClasses([ValidAnnotation::class]);
        self::assertEmpty($output, 'There should not be any invalid annotations in '.ValidAnnotation::class);

        $output = $validator->validateClasses([InvalidAnnotation::class]);
        self::assertTrue(\count($output) > 0, 'There should be at least one invalid annotations in '.InvalidAnnotation::class);
    }
}
