<?php

declare(strict_types=1);

namespace MsgPhp\User\Infra\Bundle;

use MsgPhp\User\Infra\Doctrine\Type\UserIdType;
use MsgPhp\User\Infra\Uuid\UserId;
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
        $rootNode = $treeBuilder->root(Extension::ALIAS);

        $rootNode
            ->children()
                ->scalarNode('pending_user_class')->defaultNull()->end()
                ->scalarNode('user_class')->cannotBeEmpty()->isRequired()->end()
                ->scalarNode('user_id_class')->cannotBeEmpty()->defaultValue(UserId::class)->end()
                ->scalarNode('user_role_class')->defaultNull()->end()
                ->scalarNode('user_secondary_email_class')->defaultNull()->end()
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
