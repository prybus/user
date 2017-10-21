<?php

declare(strict_types=1);

namespace MsgPhp\User\Infra\Bundle;

use MsgPhp\User\Infra\Doctrine\Type\UserIdType;
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
                ->arrayNode('doctrine')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('user_id_type_class')->cannotBeEmpty()->defaultValue(UserIdType::class)->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
