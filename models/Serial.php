<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class Serial extends ActiveRecord
{
    const DURATION_1 = '1';
    const DURATION_6 = '6';
    const DURATION_12 = '12';

    public static function getDurations()
    {
        return [
            self::DURATION_1 => '1 месяц',
            self::DURATION_6 => '6 месяцев',
            self::DURATION_12 => '1 год',
        ];
    }

    /**
    * @return string the name of the table associated with this ActiveRecord class.
    */
    public static function tableName()
    {
        return 'serial';
    }

    public function getBooks()
    {
        return $this->hasMany(Card::class, ['serial_id' => 'id']);
    }

    public function getDurationText()
    {
        return self::getDurations()[$this->duration];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['release_date'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'serial' => 'Серия',
            'release_date' => 'Дата выпуска',
            'duration' => 'Срок активности',
            'durationText' => 'Срок активности',
        ];
    }
}