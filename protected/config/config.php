<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

require_once( dirname(__FILE__) . '/../components/helpers.php');

if(file_exists(dirname(__FILE__) . '/secret.php')) {
	require_once( dirname(__FILE__) . '/secret.php');
} else {
	$secret_db_user			= 'root';
	$secret_db_password		= '';
}

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Pannónia Néptáncegyüttes - Kistarcsa 1992',
	
	'sourceLanguage'	=> 'hu',
	'language'			=> 'hu',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.galleria.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'		=> 'system.gii.GiiModule',
			'password'	=> 'admin',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'	=> array('127.0.0.1','::1'),
		),
		
	),
	
	// application components
	'components'=>array(
		'user'=>array(
			'class'				=> 'WebUser',
			// enable cookie-based authentication
			'allowAutoLogin'	=> true,
			'autoRenewCookie'	=> true,
		),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'egyuttes'=>'Site/ensemble',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		*/
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString'	=> 'mysql:host=localhost;dbname=pannonia',
			'emulatePrepare'	=> true,
			'username'			=> $secret_db_user,
			'password'			=> $secret_db_password,
			'charset'			=> 'utf8',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
		
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'			=> 'CFileLogRoute',
					'levels'		=> 'trace, error, warning',
					'maxLogFiles'	=> 3,
					'maxFileSize'	=> 100,
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		
		'session' => array (
			'sessionName' => 'pannonia_user',
			'cookieMode' => 'only',
			//'savePath' => '/path/to/new/directory',
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'nav1'		=> array(
						'Együttes'	=> array('site/ensemble'),
						'Csoportok'	=> array('group/index'),
						'Támogatók'	=> array('site/partners'),
						//'-width'	=> 100,
					),
		'news_path'	=> YiiBase::getPathOfAlias('webroot') . 'assets/news',
	),
);