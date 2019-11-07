<?php

declare(strict_types=1);

namespace  Happyr\AnnotationWarmer\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
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

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

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
