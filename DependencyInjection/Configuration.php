<?php

declare(strict_types=1);

namespace Happyr\AnnotationWarmer\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('happyr_annotation_warmer');
        if (\method_exists(TreeBuilder::class, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            $rootNode = $treeBuilder->root('happyr_annotation_warmer');
        }

        $rootNode
            ->children()
                ->arrayNode('paths')->info('Paths to where we should look for annotations')
                    ->prototype('scalar')->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
