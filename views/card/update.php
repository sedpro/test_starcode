<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Card;

/* @var $this yii\web\View */
/* @var $formModel app\models\CardForm */
/* @var $card app\models\Card */
/* @var $action string */

$this->title = 'Активация/деактивация карты';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="update-book">
    <h3><?= Html::encode($this->title) ?></h3>

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($formModel, 'status')->hiddenInput()->label(false); ?>
    <?php echo $form->field($formModel, 'old_status')->hiddenInput()->label(false); ?>

    <div class="form-group">Текущий статус карты "<strong><?php echo $card->getStatusText();?></strong>"</div>

    <div class="form-group">
        <?php echo Html::submitButton($action, ['class' => 'btn btn-primary']) ?>
        <span style="margin-left: 10px;">
            <?php echo HTML::a('Отменить', Yii::$app->getUser()->getReturnUrl());?>
        </span>
    </div>

    <?php ActiveForm::end(); ?>
</div>