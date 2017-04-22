<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property string $member_id
 * @property string $name
 * @property string $province
 * @property string $city
 * @property string $area
 * @property string $address
 * @property string $tel
 * @property string $delivery_id
 * @property string $delivery_name
 * @property string $delivery_price
 * @property string $pay_type_id
 * @property string $pay_type_name
 * @property string $price
 * @property string $status
 * @property string $trade_no
 * @property string $create_time
 */
class Order extends \yii\db\ActiveRecord
{

    public static $sendway = [
        1=>['特快专递','40.00','每张订单不满499.00元 运费40.00元, 订单4...'],
        2=>['加急快递送货上门','50.00','每张订单不满499.00元 运费40.00元, 订单4...'],
        3=>['平邮','50.00','每张订单不满499.00元  运费40.00元, 订单4...'],
    ];
    public static $payway = [
        1=>['货到付款','送货上门后再收款，支持现金、POS机刷卡、支票支付'],
        2=>['在线支付','	即时到帐，支持绝大数银行借记卡及部分银行信用卡'],
        3=>['上门自提','自提时付款，支持现金、POS刷卡、支票支付'],
        4=>['邮局汇款','	通过快钱平台收款 汇款后1-3个工作日到账'],
    ];
    public static $statusOptions = [
        1=>['待付款'],
        2=>['待发货'],
        3=>['待收货'],
        4=>['已收货'],
        5=>['已付款'],
        6=>['完成交易'],
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'name', 'province', 'city', 'area', 'address', 'tel', 'delivery_id', 'delivery_name', 'delivery_price', 'pay_type_id', 'pay_type_name', 'price', 'status', 'create_time'], 'required'],
            [['member_id', 'tel', 'delivery_id', 'pay_type_id', 'status', 'create_time'], 'integer'],
            [['delivery_price', 'price'], 'number'],
            [['name'], 'string', 'max' => 20],
            [['province', 'city', 'area', 'delivery_name', 'pay_type_name', 'trade_no'], 'string', 'max' => 30],
            [['address'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => 'Member ID',
            'name' => 'Name',
            'province' => 'Province',
            'city' => 'City',
            'area' => 'Area',
            'address' => 'Address',
            'tel' => 'Tel',
            'delivery_id' => 'Delivery ID',
            'delivery_name' => 'Delivery Name',
            'delivery_price' => 'Delivery Price',
            'pay_type_id' => 'Pay Type ID',
            'pay_type_name' => 'Pay Type Name',
            'price' => 'Price',
            'status' => 'Status',
            'trade_no' => 'Trade No',
            'create_time' => 'Create Time',
        ];
    }
}
