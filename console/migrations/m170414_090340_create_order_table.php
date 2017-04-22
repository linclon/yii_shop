<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order`.
 */
class m170414_090340_create_order_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'member_id' => $this->integer()->unsigned()->notNull(),
            'name' => $this->string(20)->notNull(),
            'province' => $this->string(30)->notNull(),
            'city' => $this->string(30)->notNull(),
            'area' => $this->string(30)->notNull(),
            'address' => $this->string(50)->notNull(),
            'tel' => $this->integer(11)->unsigned()->notNull(),
            'delivery_id' => $this->integer()->unsigned()->notNull(),
            'delivery_name' => $this->string(30)->notNull(),
            'delivery_price' => $this->decimal(7,2)->notNull(),
            'pay_type_id' => $this->integer()->unsigned()->notNull(),
            'pay_type_name' => $this->string(30)->notNull(),
            'price' => $this->decimal(7,2)->notNull(),
            'status' => $this->integer()->unsigned()->notNull(),
            'trade_no' => $this->char(30),
            'create_time' => $this->integer(15)->unsigned()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order');
    }
}
