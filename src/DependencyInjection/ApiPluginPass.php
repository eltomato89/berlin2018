<?php

declare(strict_types=1);

namespace App\DependencyInjection;

use App\JoindIn\Client;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ApiPluginPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $client = $container->findDefinition(Client::class);

        $plugins = $container->findTaggedServiceIds('api_plugin');

        foreach ($plugins as $pluginId => $data) {
            $client->addMethodCall('registerPlugin', [new Reference($pluginId)]);
        }
    }
}
