<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $container) {
    $baseDir = dirname(dirname(dirname(__DIR__)));

    $container
        ->services()
            ->defaults()
                ->autowire()
                ->autoconfigure()
                ->private()
            ->load('MsgPhp\\User\\Infra\\Console\\Command\\', $baseDir.'/Console/Command')
    ;
};
