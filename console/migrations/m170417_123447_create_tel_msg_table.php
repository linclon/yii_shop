<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tel_msg`.
 */
class m170417_123447_create_tel_msg_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('tel_msg', [
            'id' => $this->primaryKey(),
            'tel' => $this->bigInteger(11)->unsigned()->notNull(),
            'code' => $this->string(20)->notNull(),
            'times' => $this->integer(10),
            'date' => $this->string(30)->notNull(),
            'send_time' => $this->integer(15)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('tel_msg');
    }
}
