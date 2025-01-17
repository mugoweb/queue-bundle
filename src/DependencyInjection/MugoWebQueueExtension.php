<?php

namespace MugoWeb\QueueBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MugoWebQueueExtension extends Extension
{
	/**
	 * {@inheritdoc}
	 */
	public function load( array $configs, ContainerBuilder $container )
	{
		$loader = new YamlFileLoader( $container, new FileLocator( __DIR__ . '/../../config' ) );
		$loader->load( 'services.yaml' );
	}
}
