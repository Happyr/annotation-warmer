<?php

declare(strict_types=1);

namespace Happyr\AnnotationWarmer;

use Happyr\AnnotationWarmer\DependencyInjection\CompilerPass\AddLoaderToSerializerCacheWarmerPass;
use Happyr\AnnotationWarmer\DependencyInjection\CompilerPass\AddLoaderToValidationBuilderPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class HappyrAnnotationWarmerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AddLoaderToValidationBuilderPass());
        $container->addCompilerPass(new AddLoaderToSerializerCacheWarmerPass());
    }
}
