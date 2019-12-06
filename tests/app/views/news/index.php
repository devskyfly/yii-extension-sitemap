<?php
use yii\helpers\Html;
?>

<ul>
    <?foreach ($list as $item):?>
        <li> <?=Html::a($item['name'], $item['url'], $options = [])?> </li>
    <?endforeach;?>
</ul>