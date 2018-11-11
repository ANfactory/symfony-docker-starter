<?php

// generated by `make:user:msgphp`
// this configuration may be merged into your existing application configuration

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $container) {
    $container->extension('msgphp_user', [
        'class_mapping' => [
            MsgPhp\User\Entity\Role::class => App\Entity\Auth\Role::class,
            MsgPhp\User\Entity\UserRole::class => App\Entity\Auth\UserRole::class,
        ],
        'role_providers' => [
            MsgPhp\User\Role\UserRoleProvider::class,
            'default' => ['ROLE_USER'],
        ],
    ]);

    $container->services()
        ->defaults()
        ->private()
        ->autoconfigure()
        ->autowire()
        ->set(App\Console\ClassContextElementFactory::class)
        ->alias(MsgPhp\Domain\Infra\Console\Context\ClassContextElementFactoryInterface::class,
            App\Console\ClassContextElementFactory::class);
};