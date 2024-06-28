<?php

namespace ContainerP9Wuh8j;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_CgrFaNdService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.CgrFaNd' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.CgrFaNd'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService ??= $container->getService(...), [
            'entityManager' => ['services', 'doctrine.orm.default_entity_manager', 'getDoctrine_Orm_DefaultEntityManagerService', false],
            'pessoaRepository' => ['privates', 'App\\Repository\\PessoaRepository', 'getPessoaRepositoryService', true],
        ], [
            'entityManager' => '?',
            'pessoaRepository' => 'App\\Repository\\PessoaRepository',
        ]);
    }
}
