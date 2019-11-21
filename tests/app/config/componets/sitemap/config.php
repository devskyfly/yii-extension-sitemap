<?php
return [
    'class'=>'devskyfly\yiiExtensionSitemap\Sitemap',
            'path'=> '@app/web',
            'container'=>[
                'class'=>'devskyfly\yiiExtensionSitemap\Container',
                'hostClient'=>[
                    'class'=>'devskyfly\yiiExtensionSitemap\HostClient',
                    'origin'=>'http://localhost:3000',
                    'proxy'=>'',
                ],
                'initCallback' => require __DIR__.'/container-init-callback.php'
            ]
];