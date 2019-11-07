<?php

declare(strict_types=1);

namespace Happyr\AnnotationWarmer\DependencyInjection\CompilerPass;

use Happyr\AnnotationWarmer\Loader\FakeValidatorLoader;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class AddLoaderToValidationBuilderPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $validatorBuilder = $container->getDefinition('validator.builder');
        $validatorBuilder->addMethodCall('addLoader', [new Reference(FakeValidatorLoader::class)]);
    }
}
