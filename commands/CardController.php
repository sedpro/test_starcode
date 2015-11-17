<?php

namespace app\commands;

use yii\helpers\Console;
use yii;
use app\models\Card;
use app\helpers\Strings as StringHelper;

class CardController extends \yii\console\Controller
{
    public function actionOutdate()
    {
        $count = Yii::$app->db->createCommand()
            ->update('card', ['status' => Card::STATUS_OUTDATED], "(`end_date` <= NOW()) AND (`status`='active')")
            ->execute();

        $msg = StringHelper::humanPlural($count, [
            'карта деактивирована',
            'карты деактивировано',
            'карт деактивировано'
        ]);

        $this->stdout("$msg\n", Console::BOLD);
    }
}