<?php

namespace app\models;

use yii\db\ActiveRecord;

class Author extends ActiveRecord
{
    /**
    * @return string the name of the table associated with this ActiveRecord class.
    */
    public static function tableName()
    {
        return 'authors';
    }

    public function getBooks()
    {
        return $this->hasMany(Book::className(), ['author_id' => 'id']);
    }

    public function getFullName()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function attributeLabels()
    {
        return [
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'fullName' => 'Полное имя',
        ];
    }

    /**
     * Get all authors for dropdownlist widget
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getDropdownList()
    {
        $authors = self::find()->all();
        $authors = \yii\helpers\ArrayHelper::map($authors, 'id', 'fullName');
        array_unshift($authors, '');

        return $authors;
    }
}