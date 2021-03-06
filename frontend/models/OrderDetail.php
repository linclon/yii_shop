<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order_detail".
 *
 * @property integer $id
 * @property string $order_info_id
 * @property string $goods_id
 * @property string $goods_name
 * @property string $logo
 * @property string $price
 * @property string $amount
 * @property string $total_price
 */
class OrderDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_info_id', 'goods_id', 'goods_name', 'logo', 'price', 'amount', 'total_price'], 'required'],
            [['order_info_id', 'goods_id', 'amount'], 'integer'],
            [['price', 'total_price'], 'number'],
            [['goods_name'], 'string', 'max' => 32],
            [['logo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_info_id' => 'Order Info ID',
            'goods_id' => 'Goods ID',
            'goods_name' => 'Goods Name',
            'logo' => 'Logo',
            'price' => 'Price',
            'amount' => 'Amount',
            'total_price' => 'Total Price',
        ];
    }
}
