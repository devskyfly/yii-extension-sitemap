<?php

use devskyfly\yiiExtensionSitemap\Container;
use devskyfly\yiiExtensionSitemap\Page;

return function(Container $container)
{
    $container->insertPage(new Page(['url'=>'?r=site/index']));
    $container->insertPage(new Page(['url'=>'?r=site/about']));
};