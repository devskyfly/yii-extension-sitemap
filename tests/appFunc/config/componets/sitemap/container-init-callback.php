<?php

use app\models\Article;
use devskyfly\yiiExtensionSitemap\Container;
use devskyfly\yiiExtensionSitemap\Page;
use devskyfly\yiiExtensionSitemap\PageAsset;
use yii\helpers\Url;

return function(Container $container)
{
    $container->insertPage(new Page(['url'=>'?r=site/index']));
    $container->insertPage(new Page(['url'=>'?r=site/about']));

    $item_callback = function (Page $page) {
        $page->title = $page->linked_object->name;
        $page->content = $page->linked_object->content;
        $page->keywords = $page->linked_object->keywords;
        $page->description = $page->linked_object->description;
        
    };

    $config = [
        'before_title' =>"bt",
        'after_title' =>"at",
        'before_keywords' =>"bk",
        'after_keywords' =>"ak",
        'before_description' =>"bd",
        'after_description' =>"ad",
        'item_callback' => $item_callback,
        'entity_class' => Article::class, 
        'query_params'=>[]
    ];

    $container->insertPageAsset(new PageAsset($config));

};