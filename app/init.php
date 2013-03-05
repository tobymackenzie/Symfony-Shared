<?php
if(!isset($tjmGlobals)) $tjmGlobals = Array();
if(!isset($tjmGlobals['paths'])) $tjmGlobals['paths'] = Array();
if(!isset($tjmGlobals['isCli']))
	$tjmGlobals['isCli'] = (php_sapi_name() == 'cli');
// if(!isset($tjmGlobals['loadSymfony']))
// 	$tjmGlobals['loadSymfony'] = false;
if(!isset($tjmGlobals['paths']['app'])){
	$tjmGlobals['paths']['app'] = ($tjmGlobals['isCli'])
		? exec('pwd').'/app'
		: $_SERVER['DOCUMENT_ROOT'].'/../app'
	;
}
if(!isset($tjmGlobals['paths']['src'])){
	$tjmGlobals['paths']['src'] = $tjmGlobals['paths']['app']."/../src";
}
if(!isset($tjmGlobals['paths']['vendor'])){
	$tjmGlobals['paths']['vendor'] = $tjmGlobals['paths']['app']."/../vendor";
}
$tjmGlobals['paths']['shared'] = __DIR__ . '/..';

// if($tjmGlobals['loadSymfony']){
// 	require_once $tjmGlobals['paths']['app'].'/bootstrap.php.cache';
// 	require_once $tjmGlobals['paths']['app'].'/AppKernel.php';
// }
