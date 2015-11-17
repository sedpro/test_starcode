<?php

namespace app\models;

use yii\db\ActiveRecord;

class Card extends ActiveRecord
{
    const STATUS_NEW = 'new';
    const STATUS_ACTIVE = 'active';
    const STATUS_OUTDATED = 'outdated';

    public static function getStatuses()
    {
        return [
            self::STATUS_NEW => 'Не активирована',
            self::STATUS_ACTIVE => 'Активирована',
            self::STATUS_OUTDATED => 'Просрочена',
        ];
    }

    /**
    * @return string the name of the table associated with this ActiveRecord class.
    */
    public static function tableName()
    {
        return 'card';
    }

    public function getSerial()
    {
        return $this->hasOne(Serial::class, ['id' => 'serial_id']);
    }

    public function getStatusText()
    {
        return self::getStatuses()[$this->status];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'serial_id' => 'ID серии',
            'number' => 'Номер',
            'begin_date' => 'Дата начала',
            'end_date' => 'Дата окончания',
            'amount' => 'Сумма',
            'status' => 'Статус',
            'statusText' => 'Статус',
            'serialSerial' => 'Серия',
            'serialReleaseDate' => 'Дата выпуска',
            'serialDurationText' => 'Срок активности',
        ];
    }
}