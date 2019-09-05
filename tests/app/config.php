<?php
//$params = require __DIR__ . '/params.php';
//$db = require __DIR__ . '/test_db.php';

/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'basic-tests',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => dirname(__DIR__)
    ],
    'language' => 'en-US',
    'controllerNamespace'=>'tests\\app\\controllers\\',
    'components' => [
        //'db' => $db,
        /*'mailer' => [
            'useFileTransport' => true,
        ],*/
        'sitemap'=>[
            'class'=>'devskyfly\yiiExtensionSitemap\Sitemap',
            'path'=> __DIR__.'/../../tmp',
            'container'=>[
                'class'=>'devskyfly\yiiExtensionSitemap\Container',
                'hostClient'=>[
                    'class'=>'devskyfly\yiiExtensionSitemap\HostClient',
                    'origin'=>'',
                    'proxy'=>'',
                ],
                'initCallback' => function ($container) {

                }
            ]
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
        ],
    ],
    //'params' => $params,
];