<?php

declare(strict_types=1);

namespace MsgPhp\User\Infra\Bundle;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use MsgPhp\User\Entity\User;
use MsgPhp\User\Infra\Doctrine\Type\UserIdType;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class MsgPhpUserBundle extends Bundle
{
    public const EXTENSION_ALIAS = 'msgphp_user';

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new class() extends Extension implements PrependExtensionInterface
        {
            public function getAlias(): string
            {
                return MsgPhpUserBundle::EXTENSION_ALIAS;
            }

            public function getConfiguration(array $config, ContainerBuilder $container): ?ConfigurationInterface
            {
                return new Configuration();
            }

            public function load(array $configs, ContainerBuilder $container): void
            {
                //$config = $this->processConfiguration($this->getConfiguration($configs, $container), $configs);
            }

            public function prepend(ContainerBuilder $container): void
            {
                $configs = $container->getExtensionConfig($this->getAlias());
                $config = $this->processConfiguration($this->getConfiguration($configs, $container), $configs);
                $bundles = $container->getParameter('kernel.bundles');

                if (in_array(DoctrineBundle::class, $bundles, true)) {
                    $container->prependExtensionConfig('doctrine', [
                        'dbal' => [
                            'types' => [
                                UserIdType::NAME => $config['doctrine']['user_id_type_class'],
                            ],
                        ],
                        'orm' => [
                            'resolve_target_entities' => [
                                User::class => $config['user_class'],
                            ],
                            'mappings' => [
                                'MsgPhp\User\Entity' => [
                                    'dir' => dirname(__DIR__).'/Doctrine/Resources/mapping',
                                    'type' => 'xml',
                                    'prefix' => 'MsgPhp\User\Entity',
                                ],
                            ],
                        ],
                    ]);
                }
            }
        };
    }

    protected function getContainerExtensionClass(): string
    {
        throw new \BadMethodCallException('Cannot get anonymous extension class.');
    }
}
