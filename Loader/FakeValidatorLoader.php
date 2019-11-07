<?php

declare(strict_types=1);

namespace Happyr\AnnotationWarmer\Loader;

use Happyr\AnnotationWarmer\Service\AnnotationManager;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Mapping\Loader\YamlFileLoader;

/**
 * Pretend that we will load from Yaml, but serve content from annotation cache instead.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class FakeValidatorLoader extends YamlFileLoader
{
    private $manager;

    public function __construct(AnnotationManager $manager)
    {
        $this->manager = $manager;
    }

    public function loadClassMetadata(ClassMetadata $metadata)
    {
        // We dont need to do anything. The AnnotationLoader will handle things
    }

    public function getMappedClasses()
    {
        return $this->manager->getAllClasses();
    }
}
