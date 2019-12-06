<?php

$components = require __DIR__ . '/componets/components.php';
/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'functional-tests',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@app' => dirname(__DIR__),
        '@frontend' => dirname(__DIR__),
    ],
    'language' => 'en-US',
    'controllerNamespace'=>'app\\controllers',
    
    'components' => 
        array_merge($components,
            [
                'urlManager' => [
                'showScriptName' => true,
                ],
                'errorHandler' => [
                    'errorAction' => 'site/error',
                ],
                'request' => [
                'cookieValidationKey' => 'test',
                'enableCsrfValidation' => false,
                ]
        ]),
    
    //'params' => $params,
];