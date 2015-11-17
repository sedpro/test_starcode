<?php

namespace app\models;

class GeneratorForm extends \yii\base\Model
{
    public $serial;
    public $quantity;
    public $duration;

    public function rules()
    {
        return [
            [['serial','quantity', 'duration'], 'required'],
            ['quantity', 'integer', 'min' => 1],
            ['serial', 'unique', 'targetClass' => \app\models\Serial::class, 'targetAttribute' => 'serial'],
            ['serial', 'string', 'max' => 20],
        ];
    }

    public function generate()
    {
        $serial = new Serial;
        $serial->serial = $this->serial;
        $serial->duration = $this->duration;
        $serial->save();

        for ($number=1; $number<=$this->quantity; $number++) {
            $card = new Card;
            $card->serial_id = $serial->id;
            $card->number = $number;
            $card->save();
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'serial' => 'Серия',
            'quantity' => 'Количество',
            'duration' => 'Срок окончания активности',
        ];
    }

}
