<?php

namespace Cmrweb\AddressBundle;

use Symfony\Component\AssetMapper\AssetMapperInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Flex\Configurator\ContainerConfigurator;

class AddressBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
     
    public function prependExtension(ContainerConfigurator $configurator, ContainerBuilder $container): void
    {
        if (!$this->isAssetMapperAvailable($container)) {
            return;
        } 
        $container->prependExtensionConfig('twig_component', [
            'defaults' => [
                'Cmrweb\AddressBundle\Components\\' => [
                    'template_directory' => '@Address/components/',
                    'name_prefix' => 'Address',
                ],
            ],
        ]); 
        $container->prependExtensionConfig('framework', [
            'asset_mapper' => [
                'paths' => [
                    __DIR__ . '/../assets/dist' => 'cmrweb/address-bundle',
                ],
            ],
        ]);
    }

    private function isAssetMapperAvailable(ContainerBuilder $container): bool
    {
        if (!interface_exists(AssetMapperInterface::class)) {
            return false;
        }

        // check that FrameworkBundle 6.3 or higher is installed
        $bundlesMetadata = $container->getParameter('kernel.bundles_metadata');
        if (!isset($bundlesMetadata['FrameworkBundle'])) {
            return false;
        }

        return is_file($bundlesMetadata['FrameworkBundle']['path'] . '/Resources/config/asset_mapper.php');
    }
}
