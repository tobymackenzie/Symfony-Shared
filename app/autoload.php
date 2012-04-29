<?php
use Symfony\Component\ClassLoader\UniversalClassLoader;
use Doctrine\Common\Annotations\AnnotationRegistry;

if(!isset($tjmGlobals)) $tjmGlobals = Array();
if(!array_key_exists('pathVendor', $tjmGlobals)) $tjmGlobals['pathVendor'] = realpath(__DIR__.'/../../../..');
if(!array_key_exists('pathSrc', $tjmGlobals)) $tjmGlobals['pathSrc'] = realpath($tjmGlobals['pathVendor'].'/../src');

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
	'Symfony'		  => array($tjmGlobals['pathVendor'].'/symfony/src', $tjmGlobals['pathVendor'].'/bundles'),
	'Sensio'		   => $tjmGlobals['pathVendor'].'/bundles',
	'JMS'			  => $tjmGlobals['pathVendor'].'/bundles',
	'Doctrine\\Common' => $tjmGlobals['pathVendor'].'/doctrine-common/lib',
	'Doctrine\\DBAL'   => $tjmGlobals['pathVendor'].'/doctrine-dbal/lib',
	'Doctrine'		 => $tjmGlobals['pathVendor'].'/doctrine/lib',
	'Monolog'		  => $tjmGlobals['pathVendor'].'/monolog/src',
	'Assetic'		  => $tjmGlobals['pathVendor'].'/assetic/src',
	'Metadata'		 => $tjmGlobals['pathVendor'].'/metadata/src',
));
$loader->registerPrefixes(array(
	'Twig_Extensions_' => $tjmGlobals['pathVendor'].'/twig-extensions/lib',
	'Twig_'			=> $tjmGlobals['pathVendor'].'/twig/lib',
));

// intl
if (!function_exists('intl_get_error_code')) {
	require_once $tjmGlobals['pathVendor'].'/symfony/src/Symfony/Component/Locale/Resources/stubs/functions.php';
	$loader->registerPrefixFallbacks(array($tjmGlobals['pathVendor'].'/symfony/src/Symfony/Component/Locale/Resources/stubs'));
}

$loader->registerNamespaceFallbacks(array(
	$tjmGlobals['pathSrc'],
	$tjmGlobals['pathVendor'].'/bundles',
));
$loader->register();

AnnotationRegistry::registerLoader(function($class) use ($loader) {
	$loader->loadClass($class);
	return class_exists($class, false);
});
AnnotationRegistry::registerFile($tjmGlobals['pathVendor'].'/doctrine/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');

// Swiftmailer needs a special autoloader to allow
// the lazy loading of the init file (which is expensive)
require_once $tjmGlobals['pathVendor'].'/swiftmailer/lib/classes/Swift.php';
Swift::registerAutoload($tjmGlobals['pathVendor'].'/swiftmailer/lib/swift_init.php');

