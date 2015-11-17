<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'My Yii Application';
?>

<div class="site-index">

    <?php if (Yii::$app->user->isGuest):?>
        <div>
            Для работы Вы должны войти:
            <?php echo HTML::a('Войти', Url::to('/site/login'), ['class' => 'btn btn-primary']);?>
            Используйте логин <strong>demo</strong> и пароль <strong>demo</strong>
        </div>
    <?php else:?>
        <div>
            <?php echo HTML::a('Создать таблицы и наполнить их тестовыми данными', Url::to('/book/prepare'), ['class' => 'btn btn-primary']);?>
            или
            <?php echo HTML::a('Перейти к списку книг', Url::to('/book/index'), ['class' => 'btn btn-primary']);?>
        </div>
    <?php endif;?>
</div>
