<?php

use yii\db\Migration;

/**
 * Handles the creation of table `address`.
 */
class m170409_142548_create_address_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('address', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string(50)->notNull()->comment('收货人'),
            'zone' => $this->string()->notNull()->comment('所在地区'),
            'address' => $this->string()->notNull()->comment('详细地址'),
            'tel' => $this->integer(11)->notNull()->comment('电话'),
            'postcode' => $this->integer(8)->comment('邮编'),
            'status' => $this->smallInteger(4)->notNull()->defaultValue(0)->comment('电话'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('address');
    }
}
