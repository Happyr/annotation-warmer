<?php

declare(strict_types=1);

namespace  Happyr\AnnotationWarmer\DependencyInjection;

use Composer\Autoload\ClassLoader;
use Happyr\AnnotationWarmer\Service\AnnotationManager;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Debug\DebugClassLoader;
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
            $config['paths'] = [];
        }

        $paths = $container->getParameterBag()->resolveValue($config['paths']);
        $classes = [];

        foreach ($this->getAutoloadPrefixes() as $prefix => $prefixPaths) {
            foreach ($prefixPaths as $prefixPath) {
                $real = realpath($prefixPath);
                foreach ($paths as $path) {
                    if ($real === $path || false !== strstr($path, $real)) {
                        $classes = array_merge($classes, $this->getClassesInPath($path, $real, $prefix));
                    }
                }
            }
        }

        $this->addAnnotatedClassesToCompile($classes);
        $container->getDefinition(AnnotationManager::class)
            ->replaceArgument(0, $classes);
    }

    private function getClassesInPath($path, $basePath, $basePrefix)
    {
        $classes = [];
        $basePathLength = strlen($basePath);
        $finder = (new Finder())
            ->name('*.php')
            ->in($path);

        foreach ($finder as $file) {
            $filePath = substr($file->getRealpath(), $basePathLength + 1, -4);
            $fqns = $basePrefix.str_replace('/', '\\', $filePath);

            $classes[] = $fqns;
        }

        return $classes;
    }

    private function getAutoloadPrefixes()
    {
        $prefixes = [];

        foreach (spl_autoload_functions() as $function) {
            if (!\is_array($function)) {
                continue;
            }

            if ($function[0] instanceof DebugClassLoader) {
                $function = $function[0]->getClassLoader();
            }

            if (\is_array($function) && $function[0] instanceof ClassLoader) {
                $prefixes += array_filter($function[0]->getPrefixesPsr4());
            }
        }

        return $prefixes;
    }
}
