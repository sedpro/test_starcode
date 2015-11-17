<?php

use yii\helpers\Html;

/** @var app\models\Card $card */
/** @var app\models\Serial $serial */
/* @var $this yii\web\View */

$this->title = 'Профиль карты';
$this->params['breadcrumbs'][] = $this->title;

?>

<h2><?= Html::encode($this->title) ?></h2>
<div class="card-view">
    <div><?php echo $card->getAttributeLabel('id');?> : <?php echo $card->id;?></div>
    <div><?php echo $serial->getAttributeLabel('serial');?> : <?php echo $serial->serial;?></div>
    <div><?php echo $card->getAttributeLabel('number');?> : <?php echo $card->number;?></div>
    <div><?php echo $serial->getAttributeLabel('release_date');?> : <?php echo $serial->release_date;?></div>
    <div><?php echo $serial->getAttributeLabel('duration');?> : <?php echo $serial->getDurationText();?></div>
    <div><?php echo $card->getAttributeLabel('begin_date');?> : <?php echo $card->begin_date;?></div>
    <div><?php echo $card->getAttributeLabel('end_date');?> : <?php echo $card->end_date;?></div>
    <div><?php echo $card->getAttributeLabel('amount');?> : <?php echo Yii::$app->formatter->asCurrency($card->amount, 'RUB');?></div>
    <div><?php echo $card->getAttributeLabel('status');?> : <?php echo $card->getStatusText();?></div>
    <div><?= Html::a('Вернуться', Yii::$app->getUser()->getReturnUrl(), ['class' => 'btn btn-primary']) ?></div>
</div>
