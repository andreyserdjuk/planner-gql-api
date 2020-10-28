<?php

namespace Planner\TaskORMBundle\DependencyInjection;

use Planner\TaskCoreBundle\Core\Model\TaskInterface;
use Planner\TaskCoreBundle\Core\Model\TaskPriorityInterface;
use Planner\TaskCoreBundle\Core\Model\TaskPropertyInterface;
use Planner\TaskCoreBundle\Core\Model\TaskStatusInterface;
use Planner\TaskCoreBundle\DependencyInjection\Configuration;
use Planner\TaskORMBundle\Entity\Task;
use Planner\TaskORMBundle\Entity\TaskPriority;
use Planner\TaskORMBundle\Entity\TaskProperty;
use Planner\TaskORMBundle\Entity\TaskStatus;
use Planner\TaskORMBundle\Entity\User;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Security\Core\User\UserInterface;

class TaskORMExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();

        $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        $loader->load('services.yaml');

        $env = $container->getParameter('kernel.environment');
        if ($env !== 'prod') {
            $loader->load('services.dev.yaml');
        }
    }

    public function prepend(ContainerBuilder $container)
    {
        $doctrineConfig = $container->getExtensionConfig('doctrine')[0];
        $doctrineConfig['orm']['mappings']['TaskORMBundle'] = [
            'is_bundle' => true,
            'type' => 'annotation',
            'dir' => 'Entity',
            'prefix' => 'Planner\TaskORMBundle\Entity',
            'alias' => 'TaskORMBundle',
        ];

        $doctrineConfig['orm']['resolve_target_entities'][TaskInterface::class] = Task::class;
        $doctrineConfig['orm']['resolve_target_entities'][TaskPriorityInterface::class] = TaskPriority::class;
        $doctrineConfig['orm']['resolve_target_entities'][TaskPropertyInterface::class] = TaskProperty::class;
        $doctrineConfig['orm']['resolve_target_entities'][UserInterface::class] = User::class;
        $doctrineConfig['orm']['resolve_target_entities'][TaskStatusInterface::class] = TaskStatus::class;

        $container->prependExtensionConfig('doctrine', $doctrineConfig);
    }
}
