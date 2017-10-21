<?php

namespace x;

use MsgPhp\Domain\Infra\Bundle\ServiceConfigHelper;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $container) {
    ServiceConfigHelper::configureSimpleBus($container);

    $services = $container->services()
        ->defaults()
            ->autowire()
            ->public()
    ;

    foreach (glob(dirname(dirname(dirname(dirname(__DIR__)))).'/Command/Handler/*Handler.php') as $file) {
        $handler = 'MsgPhp\\User\\Command\\Handler\\'.basename($file, '.php');
        $command = 'MsgPhp\\User\\Command\\'.basename($file, 'Handler.php').'Command';

        $services->set($handler)
            ->tag('command_handler', ['handles' => $command])
        ;
    }
};
