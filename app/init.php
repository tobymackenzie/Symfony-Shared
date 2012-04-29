<?php
if(!isset($tjmGlobals)) $tjmGlobals = Array();
if(!array_key_exists('isCli', $tjmGlobals))
	$tjmGlobals['isCli'] = (php_sapi_name() == 'cli');
if(!array_key_exists('pathApp', $tjmGlobals)){
	$tjmGlobals['pathApp'] = ($tjmGlobals['isCli'])
		? exec('pwd').'/app'
		: $_SERVER['DOCUMENT_ROOT'].'/../app'
	;
}
if(!array_key_exists('pathSrc', $tjmGlobals)){
	$tjmGlobals['pathSrc'] = $tjmGlobals['pathApp']."/../src";
}
if(!array_key_exists('pathVendor', $tjmGlobals)){
	$tjmGlobals['pathVendor'] = $tjmGlobals['pathApp']."/../vendor";
}

require_once $tjmGlobals['pathApp'].'/bootstrap.php.cache';
require_once $tjmGlobals['pathApp'].'/AppKernel.php';

