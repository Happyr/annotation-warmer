<?php

declare(strict_types=1);

namespace Happyr\AnnotationWarmer\DependencyInjection\CompilerPass;

use Happyr\AnnotationWarmer\Loader\FakeSerializerLoader;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class AddLoaderToSerializerCacheWarmerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('serializer.mapping.cache_warmer')) {
            return;
        };

        $definition = $container->getDefinition('serializer.mapping.cache_warmer');
        $argument = $definition->getArgument(0);
        /** @var Definition $argumentDefinition */
        foreach ($argument as $argumentDefinition) {
            if (AnnotationLoader::class === $argumentDefinition->getClass()) {
                $argument[] = new Reference(FakeSerializerLoader::class);
                $definition->replaceArgument(0, $argument);

                return;
            }
        }
    }
}
