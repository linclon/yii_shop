<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $zone
 * @property string $address
 * @property integer $tel
 * @property integer $postcode
 * @property integer $status
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'province','city','area', 'address', 'tel'], 'required'],
            [['tel', 'postcode', 'status'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => '收货人：',
            'province' => '省：',
            'city' => '城市：',
            'area' => '地区：',
            'address' => '详细地址：',
            'tel' => '电话：',
            'postcode' => '邮编：',
            'status' => '设为默认地址：',
        ];
    }
}
