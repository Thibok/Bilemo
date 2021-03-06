<?php

/**
 * ExceptionNormalizerPass
 */

namespace AppBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * ExceptionNormalizerPass
 */
class ExceptionNormalizerPass implements CompilerPassInterface
{
    /**
     * Add all normalizers in ExceptionListener
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $exceptionListenerDef = $container->findDefinition('AppBundle\EventListener\ExceptionListener');
        $normalizers = $container->findTaggedServiceIds('app.normalizer');

        foreach ($normalizers as $id => $tags) {
            $exceptionListenerDef->addMethodCall('addNormalizer', [new Reference($id)]);
        }
    }
}