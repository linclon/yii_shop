<?php

namespace frontend\models;

use backend\models\Goods;
use Yii;

/**
 * This is the model class for table "cart".
 *
 * @property integer $id
 * @property integer $goods_id
 * @property integer $count
 * @property integer $user_id
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cart';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'count', 'user_id'], 'required'],
            [['goods_id', 'count', 'user_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => 'Goods ID',
            'count' => '数量',
            'user_id' => 'User ID',
        ];
    }

    //根据cookie 中的 good_id 到goods表中找数据
    public function findGoods($goods_id)
    {
        $goods = [];
        foreach($goods_id as $good_id){
            $goods[] = Goods::findOne(['id'=>$good_id]);
        }
        return $goods;
    }
}
