## Расширение Sitemap

### Инициализация

```php
$container=new Container();

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
```




### Использование

```php
$sitemap=new Sitemap(['container'=>$container]);
$generator=$sitemap->container->getAllPages();

foreach ($generator as $page){
    $data=$page->getContent($sitemap->request);
    BaseConsole::stdOut($page->title.PHP_EOL);
    BaseConsole::stdOut($data);
}
```
