<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

class CardSearch extends Card
{
    public $number;
    public $serialSerial;
    public $serialReleaseDate;
    public $begin_date;
    public $end_date;
    public $status;
    public $serialDuration;

    public function rules()
    {
        return [
            [['id', 'number'], 'integer'],
            ['serialSerial', 'string', 'max' => 20],
//            [['serialReleaseDate', 'begin_date', 'end_date'], 'date'],
            [['serialReleaseDate', 'begin_date', 'end_date'], 'date', 'format'=>'y-m-d'],
            ['status', 'in', 'range' => array_keys(Card::getStatuses())],
            ['serialDuration', 'in', 'range' => array_keys(Serial::getDurations())],
        ];
    }

    public function search($params)
    {
        $query = Card::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'number',
                    'begin_date',
                    'end_date',
                    'status',
                    'serialDuration' => [
                        'asc' => ['serial.duration' => SORT_ASC],
                        'desc' => ['serial.duration' => SORT_DESC]
                    ],
                    'serialReleaseDate' => [
                        'asc' => ['serial.release_date' => SORT_ASC],
                        'desc' => ['serial.release_date' => SORT_DESC]
                    ],
                    'serialSerial' => [
                        'asc' => ['serial.serial' => SORT_ASC],
                        'desc' => ['serial.serial' => SORT_DESC],
                    ],
                ],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            $query->joinWith(['serial']);
            return $dataProvider;
        }

        $query->andFilterWhere(['card.id' => $this->id]);
        $query->andFilterWhere(['card.number' => $this->number]);
        $query->andFilterWhere(['card.status' => $this->status]);
        $this->filterDate($query, 'begin_date', $this->begin_date);
        $this->filterDate($query, 'end_date', $this->end_date);

        $query->joinWith(['serial' => function ($q) {
            $q->andFilterWhere(['like', 'serial.serial', $this->serialSerial]);
            $q->andFilterWhere(['serial.duration' => $this->serialDuration]);
            $this->filterDate($q, 'serial.release_date', $this->serialReleaseDate);
        }]);

        return $dataProvider;
    }

    private function filterDate($query, $column, $value)
    {
        if ($value) {
            $query->andWhere(['between', $column,  $value . ' 00:00:00', $value . ' 23:59:59']);
        }
    }
}