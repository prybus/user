<?php

use MsgPhp\User\Infra\Doctrine\SqlEmailLookup;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $container) {
    $baseDir = dirname(dirname(dirname(__DIR__)));

    $container
        ->services()
            ->defaults()
                ->autowire()
                ->autoconfigure()
                ->private()
            ->load('MsgPhp\\User\\Infra\\Doctrine\\Repository\\', $baseDir.'/Doctrine/Repository')
            ->set(SqlEmailLookup::class)
    ;
};
