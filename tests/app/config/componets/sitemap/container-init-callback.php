<?php

use app\models\Article;
use devskyfly\yiiExtensionSitemap\Container;
use devskyfly\yiiExtensionSitemap\Page;
use devskyfly\yiiExtensionSitemap\PageAsset;

return function(Container $container)
{
    $container->insertPage(new Page(['url'=>'?r=site/index', 'priority' => 1]));
    $container->insertPage(new Page(['url'=>'?r=site/about', 'priority' => 0.8]));

    $item_callback = function (Page $page) {
        $page->title = $page->linked_object->name;
        $page->content = $page->linked_object->content;
        $page->keywords = $page->linked_object->keywords;
        $page->description = $page->linked_object->description;

        $route = $page->asset->route;
        $page->url = sprintf($route, $page->title);
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
        'route' => "?r=article/index&code=%s",
        'query_params'=>[]
    ];

    $container->insertPageAsset(new PageAsset($config));

};