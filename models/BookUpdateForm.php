<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class BookUpdateForm extends Model
{
    public $name;
    public $author_id;
    public $date;
    public $currentImage;
    public $deleteImage;

    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['name','author_id', 'date'], 'required'],
            [['date'], 'date', 'format' => 'YYYY-mm-dd'],
            [['author_id'], 'integer'],

            [['deleteImage'], 'string'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg']
        ];
    }

    /**
     * Fills the form with provided book's data
     *
     * @param Book $book
     * @return boolean whether the form successfully filled with post's data
     */
    public function fill($book) {
        if ($book) {
            $this->name = $book->name;
            $this->author_id = $book->author_id;
            $this->date = $book->date;
            $this->currentImage = $book->preview;
            return true;
        }
        return false;
    }

    /**
     * @param Book|null $book
     * @return boolean whether the book successfully edited
     */
    public function update($book)
    {
        if ($book) {
            if ($this->validate()) {
                $book->name = $this->name;
                $book->author_id = $this->author_id;
                $book->date = $this->date;

                if ($this->imageFile || $this->deleteImage) {
                    if (!empty($book->preview)) {
                        $imageToDelete = Yii::getAlias('@webroot') . Book::IMAGE_FOLDER . $book->preview;
                        if (file_exists($imageToDelete)) {
                            unlink($imageToDelete);
                        }
                        $book->preview = '';
                    }
                }
                if ($this->imageFile) {
                    $imageName = Yii::$app->security->generateRandomString() . '.' . $this->imageFile->extension;
                    if (!$this->imageFile->saveAs(Yii::getAlias('@webroot') . Book::IMAGE_FOLDER . $imageName)) {
                        return false;
                    }
                    $book->preview = $imageName;
                }

                return $book->save();
            }
        }
        return false;
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
            'author_id' => 'Автор',
        ];
    }

}
