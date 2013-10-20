<?php
namespace TJM\Shared\Component;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel{
	/*=====
	==initialization
	=====*/
	public function registerBundles(){
		$bundles = array(
			//--standard
			//---framework
			new \Symfony\Bundle\FrameworkBundle\FrameworkBundle()
			//---standard symfony
			,new \Symfony\Bundle\SecurityBundle\SecurityBundle()
			,new \Symfony\Bundle\TwigBundle\TwigBundle()
			,new \Symfony\Bundle\MonologBundle\MonologBundle()
			,new \Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle()
			,new \Symfony\Bundle\AsseticBundle\AsseticBundle()
			,new \Doctrine\Bundle\DoctrineBundle\DoctrineBundle()
			,new \Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle()
		);

		if (in_array($this->getEnvironment(), array('dev', 'test'))) {
			$bundles[] = new \Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
			$bundles[] = new \Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
			$bundles[] = new \Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
		}

		return $bundles;
	}

	public function registerContainerConfiguration(LoaderInterface $loader){
		$appPath = (isset($GLOBALS['tjmGlobals']) && isset($GLOBALS['tjmGlobals']['paths']) && isset($GLOBALS['tjmGlobals']['paths']['app']))
			? $GLOBALS['tjmGlobals']['paths']['app']
			: __DIR__.'/../../../../../app'
		;
		$loader->load($appPath.'/config/config_'.$this->getEnvironment().'.yml');
	}

	/*=====
	==process requests
	=====*/
	/*
	Method: processRequest
	Process a request in the standard edition fashion.
	Parameters:
		options(Map):
			cache(Boolean): whether to use an AppCache
			request(Request): specify an alternative request to process
	*/
	public function processRequest($options = Array()){
		$kernel = $this;
		$kernel->loadClassCache();
		if(isset($options['cache']) && $options['cache'] === true){
			//-# untested
			$kernel = new \AppCache($kernel);
		}
		if(isset($options['request'])){
			$request = $options['request'];
		}else{
			$request = Request::createFromGlobals();
		}
		$response = $kernel->handle($request);
		$response->send();
		$kernel->terminate($request, $response);
	}
}
