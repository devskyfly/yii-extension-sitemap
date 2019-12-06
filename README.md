## Расширение Sitemap

### Конфигурация

```php 
//Компонент
return [
    'bootstrap'=>[
        'sitemap' //компонент регистрирует свои консольные команды  
    ]
    'components'=>[
        'sitemap' => [
            'class'=>'devskyfly\yiiExtensionSitemap\Sitemap',
            'initCallback'=>require_once __DIR__.'/sitemap-callback.php'
        ],
    ]
];
```

### Инициализация sitemap-callback.php

```php
use app\models\moduleAdminPanel\contentPanel\entityWithoutSection\EntityWithoutSection;
use devskyfly\yiiExtensionSitemap\Page;
use devskyfly\yiiExtensionSitemap\PageAsset;

return $initCallback = function($container){

    /**********************************************************************/
    /** StaticPage **/
    /**********************************************************************/
        
    $pages=[
        ['url'=>'?r=site/index', 'priority' => 1],
        ['url'=>'?r=site/about', 'priority' => 0.8]
    ];

    foreach ($pages as $page_config) {
        $page = new Page($page_config);
        $container->insertPage($page);
    }
        
    /**********************************************************************/
    /** DinamicPages **/
    /**********************************************************************/

    $item_callback = function (Page $page) {
        $page->title = $page->linked_object->name;
        $page->content = $page->linked_object->content;
        $page->keywords = $page->linked_object->keywords;
        $page->description = $page->linked_object->description;

        $route = $page->asset->route;
        $page->url = sprintf($route, $page->title);
    };

    $pages_asserts[] = [
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
    ];

    foreach ($pages_asserts as $page_config) {
        $page_asset = new PageAsset($page_config);
        $container->insertPageAsset($page_asset);
    }

};
```



### Использование

```php
$sitemap=Yii::$app->sitemap;
$generator=$sitemap->container->getAllPages();

foreach ($generator as $page){
    $data=$page->getContent();
    BaseConsole::stdOut($page->title.PHP_EOL);
    BaseConsole::stdOut($data);
}
```
