<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\base\UserException;
use devskyfly\php56\types\Obj;

$this->title = $name;
?>
<main>
	<?if(Obj::isA($exception,UserException::class)):?>
		<h1><?= Html::encode($name) ?></h1>
	<?else:?>
		<h1> Server error (#500) </h1>
	<?endif;?>
</main>
