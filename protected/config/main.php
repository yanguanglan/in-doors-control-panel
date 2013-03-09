<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'     => 'Панель управления',
	'language' => 'ru',
	'charset'  => 'utf-8',

	// preloading 'log' component
	'preload'=>array('log', 'bootstrap'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
    'billing',
    'vpn',
    'hub',
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'h632&G3h8c',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1','10.105.12.217'),
      'generatorPaths' => array('bootstrap.gii'),
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
      'urlSuffix'=>'.html',
			'showScriptName'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=controlpanel',
			'emulatePrepare' => true,
			'username' => 'controlpanel',
			'password' => 'NwHbWNsnpvZT6VnP',
			'charset' => 'utf8',
//      'enableProfiling' => true,
//      'enableParamLogging' => true,
		),
    'dbUTM5' => array(
      'class' => 'CDbConnection',
			'connectionString' => 'mysql:host=127.0.0.1;dbname=UTM5',
			'emulatePrepare' => true,
      'schemaCachingDuration' => 3600,
			'username' => 'utm5',
			'password' => 'xVft0EAdC',
			'charset' => 'utf8',
//      'enableProfiling' => true,
//      'enableParamLogging' => true,
    ),
    'authManager' => array(
      'class' => 'CDbAuthManager',
      'connectionID' => 'db',
    ),
    'cache' => array(
      'class' => 'system.caching.CFileCache',
    ),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				array(
					'class'=>'CWebLogRoute',
          'categories' => 'application',
          'levels' => 'error, warning, trace, profile, info',
				),
				array(
					'class'=>'CProfileLogRoute',
          'enabled' => true,
          'levels' => 'profile',
				),
        /*
        array(
          'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
          // Access is restricted by default to the localhost
          'ipFilters'=>array('127.0.0.1','::1','10.105.12.216/29'),
        ),
        */
        array(
          'class'=>'CDbLogRoute',
          'levels'=>'info, warning, error',
          'categories'=>'volgocom.*',
          'logTableName'=>'log',
          'connectionID'=>'db',
          'enabled'=>true,
          'filter'=>array(
            'class'=>'CLogFilter',
            'prefixUser'=>true,
            'logUser'=>false,
            'logVars'=>array(),
          ),
        ),
			),
		),
    'bootstrap' => array(
      'class' => 'ext.bootstrap.components.Bootstrap',
    ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'admin@volgocom.ru',
	),
);