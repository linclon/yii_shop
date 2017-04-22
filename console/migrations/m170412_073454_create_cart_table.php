<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cart`.
 */
class m170412_073454_create_cart_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cart', [
            'id' => $this->primaryKey(),
            'goods_id' => $this->integer()->notNull(),
            'count' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('cart');
    }
}
