<?php

namespace ContainerP9Wuh8j;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getPessoaControllereditService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.CgrFaNd.App\Controller\PessoaController::edit()' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.CgrFaNd.App\\Controller\\PessoaController::edit()'] = ($container->privates['.service_locator.CgrFaNd'] ?? $container->load('get_ServiceLocator_CgrFaNdService'))->withContext('App\\Controller\\PessoaController::edit()', $container);
    }
}
