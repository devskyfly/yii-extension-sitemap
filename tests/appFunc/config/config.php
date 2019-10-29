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
        '@app' => dirname(__DIR__)
    ],
    'language' => 'en-US',
    'controllerNamespace'=>'app\\controllers',
    //'controllerPath'=>
    'components' => [
        'sitemap'=>[
            'class'=>'devskyfly\yiiExtensionSitemap\Sitemap',
            'path'=> __DIR__.'/../web',
            'container'=>[
                'class'=>'devskyfly\yiiExtensionSitemap\Container',
                'hostClient'=>[
                    'class'=>'devskyfly\yiiExtensionSitemap\HostClient',
                    'origin'=>'http://localhost:3000',
                    'proxy'=>'',
                ],
                'initCallback' => require __DIR__.'/sitemap/container-init-callback.php'
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