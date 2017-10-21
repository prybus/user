<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $container) {
    $baseDir = dirname(dirname(dirname(dirname(__DIR__))));

    $container
        ->services()
            ->defaults()
                ->autowire()
                ->public()
    ;

    foreach (glob($baseDir.'/Command/Handler/*Handler.php') as $file) {
        $handler = 'MsgPhp\\User\\Command\\Handler\\'.basename($file, '.php');
        $command = 'MsgPhp\\User\\Command\\'.basename($file, 'Handler.php').'Command';

        $container->services()->set($handler)
            ->tag('command_handler', ['handles' => $command])
        ;
    }
};
