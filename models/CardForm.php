<?php

namespace app\models;

use yii\db\Expression;

class CardForm extends \yii\base\Model
{
    public $status;
    public $old_status;

    public function rules()
    {
        return [
            [['status', 'old_status'], 'required'],
            [['status', 'old_status'], 'in', 'range' => array_keys(Card::getStatuses())],
        ];
    }

    public function fill($card) {
        if ($card) {
            $this->old_status = $card->status;
            $this->status = $this->getNewStatus($card->status);
            return true;
        }
        return false;
    }

    public function update($card)
    {
        if ($card && $this->validate()) {
            $card->status = $this->status;
            if ($card->status==Card::STATUS_ACTIVE) {
                $card->begin_date = new Expression('NOW()');
                $card->end_date = new Expression('DATE_ADD(now(), INTERVAL ' . $card->serial->duration . ' month)');
            }
            if ($card->status==Card::STATUS_NEW) {
                $card->begin_date = null;
                $card->end_date = null;
            }

            return $card->save();
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'status' => 'Статус',
        ];
    }

    /**
     * Поскольку правила активирования/деактивирования карт в ТЗ не прописаны,
     * предполагаем, что старые карты можно активировать заново вручную,
     * и что деактивация - это проставление статуса "не активирована"
     *
     * @param $oldStatus
     * @return string
     */
    private function getNewStatus($oldStatus)
    {
        switch($oldStatus) {
            case Card::STATUS_NEW:
                return Card::STATUS_ACTIVE;
            case Card::STATUS_ACTIVE:
                return Card::STATUS_NEW;
            case Card::STATUS_OUTDATED:
                return Card::STATUS_ACTIVE;
        }
    }
}
