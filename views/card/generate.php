<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Serial;

/* @var $this yii\web\View */
/* @var $formModel app\models\GeneratorForm */

$this->title = 'Генератор карт';
$this->params['breadcrumbs'][] = $this->title;

?>

<div>
    <h2><?= Html::encode($this->title) ?></h2>

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($formModel, 'serial') ?>

    <?php echo $form->field($formModel, 'quantity') ?>

    <?php echo $form->field($formModel, 'duration')->dropDownList(Serial::getDurations()); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        <span style="margin-left: 10px;">
            <?php echo HTML::a('Отменить', Yii::$app->getUser()->getReturnUrl());?>
        </span>
    </div>

    <?php ActiveForm::end(); ?>
</div>