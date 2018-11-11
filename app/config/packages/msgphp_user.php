<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $container) {
    $container->extension('msgphp_user', [
        'class_mapping' => [
            MsgPhp\User\Entity\User::class => App\Entity\Auth\User::class,
        ],
    ]);
};
