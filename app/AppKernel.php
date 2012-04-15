<?php
namespace TJM\Shared\app;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel{
	protected $pathApp = null;

	public function registerBundles(){
		$bundles = array(
			new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
			new \Symfony\Bundle\SecurityBundle\SecurityBundle(),
			new \Symfony\Bundle\TwigBundle\TwigBundle(),
			new \Symfony\Bundle\MonologBundle\MonologBundle(),
			new \Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
			new \Symfony\Bundle\DoctrineBundle\DoctrineBundle(),
			new \Symfony\Bundle\AsseticBundle\AsseticBundle(),
			new \Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
			new \JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
		);

		if (in_array($this->getEnvironment(), array('dev', 'test'))) {
			$bundles[] = new \Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
			$bundles[] = new \Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
			$bundles[] = new \Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
		}

		return $bundles;
	}

	public function registerContainerConfiguration(LoaderInterface $loader){
		$pathApp = ($this->pathApp) ? $this->pathApp : __DIR__.'/../../../../../app';
		$loader->load($pathApp.'/config/config_'.$this->getEnvironment().'.yml');
	}
}

