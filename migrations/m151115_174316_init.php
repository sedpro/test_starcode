<?php

use yii\db\Migration;
use yii\db\Schema;
use yii\db\Expression;
use app\models\Card;
use app\models\Serial;

class m151115_174316_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

//    * серия карты
//    * номер карты
//    * дата выпуска карты
//    * дата окончания активности карты
//    * дата использования
//    * сумма
//    * статус карты (не активирована/активирована/просрочена)

        $this->createTable('{{%serial}}', [
            'id' => $this->primaryKey(),
            'serial' => $this->string(20)->notNull(),
            'release_date' => $this->dateTime()->notNull(),
            'duration' => "enum ('" . implode("','", array_keys(Serial::getDurations())) . "') not null",
        ], $tableOptions);

        $this->createIndex('serial_uniq', '{{%serial}}', ['serial'], true);

        $this->createTable('{{%card}}', [
            'id' => $this->primaryKey(),
            'serial_id' => $this->integer()->notNull(),
            'number' => $this->integer()->notNull(),
            'begin_date' => $this->dateTime()->defaultValue(null),
            'end_date' => $this->dateTime()->defaultValue(null),
            'amount' => $this->money()->notNull()->defaultValue(0),
            'status' => "enum ('" . implode("','", array_keys(Card::getStatuses())) . "') not null default '" . Card::STATUS_NEW . "'",
        ], $tableOptions);

        $this->createIndex('serial_number_uniq', '{{%card}}', ['serial_id', 'number'], true);

        $this->addForeignKey('FK_card_serial', '{{%card}}', 'serial_id', '{{%serial}}', 'id');
    }

    public function down()
    {
        $this->dropTable('{{%card}}');
        $this->dropTable('{{%serial}}');
    }
}
