## Расширение Sitemap

### Конфигурация common

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
]
```

### Инициализация sitemap-callback.php

```php
use app\models\moduleAdminPanel\contentPanel\entityWithoutSection\EntityWithoutSection;
use devskyfly\yiiExtensionSitemap\Page;
use devskyfly\yiiExtensionSitemap\PageAsset;

return $initCallback=function($container){
    /**********************************************************************/
    /** StaticPage **/
    /**********************************************************************/
    
    $pages=[
        [
            'title'=>'Index',
            'description'=>'Описание страницы',
            'keywords'=>'Ключевые слова',
            'route'=>'site/index'
        ],
    ];
    
    foreach ($pages as $page_config)
    {
        $page=new Page($page_config);
        $container->insertPage($page);
    }
    
    /**********************************************************************/
    /** DinamicPages **/
    /**********************************************************************/
    
    $pages_asserts=[
        [
            'class'=>EntityWithoutSection::class,
            'route'=>'site/index',
            
            'query_params'=>['active'=>'Y'],
            'init_callback'=>function($item){
                return [
                    'title'=>$item->extensions['page']->title,
                    'keywords'=>$item->extensions['page']->keywords,
                    'description'=>$item->extensions['page']->description,
                    'route'=>'/moduleAdminPanel/contentPanel/entity-without-section',
                    'route_params'=>['entity_id'=>$item->id]
                ];
            },
            'content_callback'=>function($item){
            return $item->extensions['page']->detail_text;
            }
            ],
            ];
    
    foreach ($pages_asserts as $page_config)
    {
        $page_asset=new PageAsset($page_config);
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
