<?php
use Symfony\Component\ClassLoader\UniversalClassLoader;
use Doctrine\Common\Annotations\AnnotationRegistry;

if(!isset($tjmGlobals)) $tjmGlobals = Array();
if(!array_key_exists('pathApp', $tjmGlobals)) $tjmGlobals['pathApp'] = realpath(__DIR__.'/../../../../../app');

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
	'Symfony'		  => array($tjmGlobals['pathApp'].'/../vendor/symfony/src', $tjmGlobals['pathApp'].'/../vendor/bundles'),
	'Sensio'		   => $tjmGlobals['pathApp'].'/../vendor/bundles',
	'JMS'			  => $tjmGlobals['pathApp'].'/../vendor/bundles',
	'Doctrine\\Common' => $tjmGlobals['pathApp'].'/../vendor/doctrine-common/lib',
	'Doctrine\\DBAL'   => $tjmGlobals['pathApp'].'/../vendor/doctrine-dbal/lib',
	'Doctrine'		 => $tjmGlobals['pathApp'].'/../vendor/doctrine/lib',
	'Monolog'		  => $tjmGlobals['pathApp'].'/../vendor/monolog/src',
	'Assetic'		  => $tjmGlobals['pathApp'].'/../vendor/assetic/src',
	'Metadata'		 => $tjmGlobals['pathApp'].'/../vendor/metadata/src',
));
$loader->registerPrefixes(array(
	'Twig_Extensions_' => $tjmGlobals['pathApp'].'/../vendor/twig-extensions/lib',
	'Twig_'			=> $tjmGlobals['pathApp'].'/../vendor/twig/lib',
));

// intl
if (!function_exists('intl_get_error_code')) {
	require_once $tjmGlobals['pathApp'].'/../vendor/symfony/src/Symfony/Component/Locale/Resources/stubs/functions.php';
	$loader->registerPrefixFallbacks(array($tjmGlobals['pathApp'].'/../vendor/symfony/src/Symfony/Component/Locale/Resources/stubs'));
}

$loader->registerNamespaceFallbacks(array(
	$tjmGlobals['pathApp'].'/../src',
	$tjmGlobals['pathApp'].'/../vendor/_bundles',
));
$loader->register();

AnnotationRegistry::registerLoader(function($class) use ($loader) {
	$loader->loadClass($class);
	return class_exists($class, false);
});
AnnotationRegistry::registerFile($tjmGlobals['pathApp'].'/../vendor/doctrine/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');

// Swiftmailer needs a special autoloader to allow
// the lazy loading of the init file (which is expensive)
require_once $tjmGlobals['pathApp'].'/../vendor/swiftmailer/lib/classes/Swift.php';
Swift::registerAutoload($tjmGlobals['pathApp'].'/../vendor/swiftmailer/lib/swift_init.php');

