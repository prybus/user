<?php

use MsgPhp\User\Infra\Doctrine\SqlEmailLookup;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $container) {
    $container->services()
        ->defaults()
            ->autowire()
            ->autoconfigure()
            ->private()
        ->load('MsgPhp\\User\\Infra\\Doctrine\\Repository\\', dirname(dirname(dirname(__DIR__))).'/Doctrine/Repository')
        ->set(SqlEmailLookup::class)
    ;
};
