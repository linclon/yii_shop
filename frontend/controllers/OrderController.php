<?php

namespace frontend\controllers;

use backend\models\Goods;
use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\Order;
use frontend\models\OrderDetail;
use yii\db\Exception;
use yii\filters\AccessControl;

class OrderController extends \yii\web\Controller
{
    public $layout = 'order';
    public function actionIndex()
    {
        //实例化order表
        $model = new Order();
        //分配地址表数据到视图
        $models = Address::find()->all();
        //获取当前用户购物车表的数据
        $carts = Cart::find()->where(['user_id'=>\Yii::$app->user->id])->all();
        //接收表单数据
        $request = \Yii::$app->request;
        if($request->isPost){
            //取出数据
            $address_id = $request->post('address_id');
            $delivery_id = $request->post('delivery_id');
            $pay_type_id = $request->post('pay_type_id');
            //根据地址Id获取地址表数据
            $address = Address::findOne(['id'=>$address_id]);
            //获取值并赋值
            $model->name = $address->name;
            $model->province = $address->province;
            $model->city = $address->city;
            $model->area = $address->area;
            $model->address = $address->address;
            $model->tel = $address->tel;
            //获取当前用户id
            $model->member_id = \Yii::$app->user->id;
            //获取模型中配送方式数据 并赋值
            $d = $model::$sendway;
            $model->delivery_id = $delivery_id;
            $model->delivery_name = $d[$delivery_id][0];
            $model->delivery_price = $d[$delivery_id][1];
            //获取支付数据
            $pay = $model::$payway;
            $model->pay_type_id = $pay_type_id;
            $model->pay_type_name = $pay[$pay_type_id][0];
            $model->price = intval($request->post('sum'));
            //获取交易号信息

            $model->status = 1;
            $model->trade_no = date('Ymdhms',time());
            //获取时间
            $model->create_time = time();


            //开启事物
            $db = \Yii::$app->db;
            $transactions =  $db->beginTransaction();
            try{
                //保存到order表
                $model->save();

                //获取当前用户购物车里的商品id
                $goods_id = Cart::find()->where(['user_id' => \Yii::$app->user->id])->asArray()->all();
                //遍历商品id 查询商品数据
                foreach ($goods_id as $goodsinfo) {
                    //实例化订单表 (循环每次都需要实例化-->注意!)
                    $detial = new OrderDetail();
                    //根据遍历出的id到goods表取出值
                    $goods = Goods::find()->where(['id' => $goodsinfo['goods_id']])->one();
                    //一一赋值
                    $detial->goods_name = $goods->name;
                    $detial->logo = $goods->logo;
                    $detial->price = $goods->shop_price;
                    //order_info_id为订单表保存后的id
                    $detial->order_info_id = $model->id;
                    $detial->goods_id = $goods->id;
                    //判断如果购物车数量大于商品库存
                    if ($goodsinfo['count'] > $goods->stock) {
                        //抛出异常
                        throw new Exception('商品' . $goods->name . '数量不足!');
                    }else{
                        //否则修改商品数量:库存-购物车数量
                        $goods->stock = $goods->stock - $goodsinfo['count'];
                        $goods->save(false);
                    }
                    //数量为cart表里的数量
                    $detial->amount = $goodsinfo['count'];
                    //总价为商品的单价*数量
                    $detial->total_price = $goods->shop_price * $goodsinfo['count'];
                    //保存到detial
                    $detial->save();
                    $transactions->commit();
                }
            //捕获异常
            }catch (Exception $e){
                //回滚
                $transactions->rollBack();
                \Yii::$app->session->setFlash('danger','商品数量不足!');
            }


            //保存成功后删除当前用户的购物车数据
            Cart::deleteAll(['user_id'=>\Yii::$app->user->id]);
        }

        //定义空数组容器
        $goods = [];
        //遍历购物车数据
        foreach($carts as $goods_id=>$num){
            //根据遍历的商品id获取商品信息,并以数组形式输出
            $datas = Goods::find()->where(['id'=>$num->goods_id])->asArray()->one();
            //在datas中定义字段保存商品数量
            $datas['num'] = $num->count;
            //放到空数组里
            $goods[] = $datas;
        }
        //分配数据到页面
        return $this->render('index',['models'=>$models,'goods'=>$goods,'model'=>$model]);
    }




    //acf behaviors
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }



}
