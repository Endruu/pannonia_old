<?php

if(file_exists(dirname(__FILE__) . '/secret.php')) {
	require_once( dirname(__FILE__) . '/secret.php');
} else {
	$secret_db_user			= 'root';
	$secret_db_password		= '';
}

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',
	// application components
	
	'components'=>array(
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=pannonia',
			'emulatePrepare' => true,
			'username' => $secret_db_user,
			'password' => $secret_db_password,
			'charset' => 'utf8',
		),
	),
);