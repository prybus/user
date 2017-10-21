<?php

declare(strict_types=1);

namespace MsgPhp\User\Infra\Bundle;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root(MsgPhpUserBundle::EXTENSION_ALIAS);

        $rootNode
            ->children()
                ->scalarNode('user_class')->cannotBeEmpty()->isRequired()->end()
            ->end();

        return $treeBuilder;
    }
}
