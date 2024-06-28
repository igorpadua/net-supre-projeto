<?php

namespace ContainerP9Wuh8j;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_E7DSjsGService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.E7DSjsG' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.E7DSjsG'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService ??= $container->getService(...), [
            'pessoaRepository' => ['privates', 'App\\Repository\\PessoaRepository', 'getPessoaRepositoryService', true],
        ], [
            'pessoaRepository' => 'App\\Repository\\PessoaRepository',
        ]);
    }
}
