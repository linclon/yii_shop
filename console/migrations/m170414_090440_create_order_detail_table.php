<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order_detail`.
 */
class m170414_090440_create_order_detail_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order_detail', [
            'id' => $this->primaryKey(),
            'order_info_id' => $this->integer(10)->unsigned()->notNull(),
            'goods_id' => $this->integer(10)->unsigned()->notNull(),
            'goods_name' => $this->string(32)->notNull(),
            'logo' => $this->string()->notNull(),
            'price' => $this->decimal(10,2)->notNull(),
            'amount' => $this->integer(10)->unsigned()->notNull(),
            'total_price' => $this->decimal(10,2)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order_detail');
    }
}
