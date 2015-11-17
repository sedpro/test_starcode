<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class Book extends ActiveRecord
{
    const IMAGE_FOLDER = '/uploads/images/';

    /**
    * @return string the name of the table associated with this ActiveRecord class.
    */
    public static function tableName()
    {
        return 'books';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date_create', 'date_update'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['date_update'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function getAuthor()
    {
        return $this->hasOne(Author::className(), ['id' => 'author_id']);
    }

    public function getAuthorName() {
        return $this->author->firstname . ' ' . $this->author->lastname;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'date_create' => 'Дата добавления',
            'date_update' => 'Дата изменения',
            'preview' => 'Превью',
            'date' => 'Дата выхода книги',
            'authorName' => 'Автор',
        ];
    }

    public function getPreviewurl()
    {
        return Yii::getAlias('@web') . self::IMAGE_FOLDER . $this->preview;
    }

    public function beforeDelete()
    {
        if (!empty($this->preview)) {
            $fileName = Yii::getAlias('@webroot') . self::IMAGE_FOLDER . $this->preview;
            if (file_exists($fileName)) {
                unlink($fileName);
            }
        }

        return parent::beforeDelete();
    }
}