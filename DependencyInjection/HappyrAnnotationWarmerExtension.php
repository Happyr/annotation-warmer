<?php

declare(strict_types=1);

namespace  Happyr\AnnotationWarmer\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class HappyrAnnotationWarmerExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if (empty($config['paths'])) {
            $config['paths'] = '%kernel.project_dir%/src';
        }

        $paths = $container->getParameterBag()->resolveValue($config['paths']);

        $finder = (new Finder())
            ->name('*.php')
            ->in($paths);

        $classes = [];
        foreach ($finder as $file) {

        }
        $this->addAnnotatedClassesToCompile($classes);
    }
}
