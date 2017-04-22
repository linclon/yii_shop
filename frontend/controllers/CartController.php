<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/12
 * Time: 15:02
 */

namespace frontend\controllers;


use backend\models\Goods;
use frontend\components\CartCookieHandler;
use frontend\models\Cart;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Cookie;

class CartController extends Controller
{
    public $enableCsrfValidation = false;

    public $layout = 'cart';


    public function actionIndex()
    {
        var_dump(\Yii::$app->user->id);
    }


    /*
     * 提示页
     */
    public function actionNotice($count,$goods_id)
    {

        //如果是游客,保存数据到cookie中
        if(\Yii::$app->user->isGuest){
            //实例化
       /*     $cookies = \Yii::$app->request->cookies;
            //先取出cookie中的数据
            $cookie = $cookies->get('cart');
            //如果值为空
            if($cookie == null){
                $cart = [];//给一个空数组
            }else{
                $cart = unserialize($cookie->value);//有值,取出并反序列化
            }
            //判断cookie中是否有当前商品
            if(array_key_exists($goods_id,$cart)){
                $cart[$goods_id] += $count;
            }else{
                $cart[$goods_id] = $count;
            }
            //把数量和商品id保存到cookie中
            $cookies = \Yii::$app->response->cookies;//实例化组件
            //创建对象并传参
            $cookie = new Cookie([
                'name'=>'cart',
                'value'=>serialize($cart),
            ]);
            //保存到cookie
            $cookies->add($cookie);*/

            \Yii::$app->CartCookieHandler->addCart($goods_id,$count)->save();
            //跳转到购物车页面
            return $this->redirect(['cart/cart']);


        }else{//如果已经登录,保存数据到数据库

            $model = new Cart();
            $num = Cart::findOne(['goods_id'=>$goods_id]);
            if($num){
                $num->count += $count;
                $num->save();
            }else{
                $model->count = $count;
                $model->user_id = \Yii::$app->user->id;
                $model->goods_id = $goods_id;

            }
            $model->save();

        }
    }

    /*
     * 购物车
     */
    public function actionCart()
    {
        //游客从cookie中取值,展示到页面
        if(\Yii::$app->user->isGuest){
            //实例化cookie
         /*   $cookies = \Yii::$app->request->cookies;
            //取出cookie中的cart
            $data = $cookies->get('cart');
            //判断值是否存在
            if($data == null){
                $cart = [];//给一个空数组
            }else{
                $cart = unserialize($data->value);//有值,取出并反序列化
            }*/
            $cart = \Yii::$app->CartCookieHandler->getCart();
            //定义一个空数组来保存数据
            $models=[];
            //遍历
           foreach($cart as $id=>$num){
               //根据得到的goods_id查找数据
               $goods = Goods::find()->where(['id'=>$id])->asArray()->one();
               //定义一个字段存放数量
               $goods['num'] = $num;
               //放到数组里
               $models[] = $goods;
           }
            unset($models['num']);
            //分配数据到视图
            return $this->render('cart',['models'=>$models]);

        }else{
            //2.获取cookie中的值保存到数据库
//            $cart_incookie = \Yii::$app->CartCookieHandler->getCart();


            //1.从数据库取值,展示到页面
            //根据user_id取出对应数据
            $carts = Cart::find()->where(['user_id'=>\Yii::$app->user->id])->asArray()->all();
            $models = [];
            foreach($carts as $cart){

//                var_dump($cart['goods_id']);exit;
                //根据得到的goods_id查找数据
                $goods = Goods::find()->where(['id'=>$cart['goods_id']])->asArray()->one();
                //定义一个字段存放数量
                $goods['num'] = $cart['count'];
                //放到数组里
                $models[] = $goods;
            }
//            var_dump($models);exit;
            //根据datas里面的good_id到goods表取出数据
            //分配到页面
            return $this->render('cart',['models'=>$models]);
        }
//        var_dump($cart);
    }

    public function actionChange($status)
    {
        switch($status){
            case 'edit':
                $goods_id = \Yii::$app->request->post('goods_id');
                $num = \Yii::$app->request->post('num');
                if(\Yii::$app->user->isGuest) {
                    /*$cookies = \Yii::$app->request->cookies; //实例化cookie
                    $data = $cookies->get('cart'); //取出cookie中的cart
                    //判断值是否存在
                    if ($data == null) {
                        $cart = [];//给一个空数组
                    } else {
                        $cart = unserialize($data->value);//有值,取出并反序列化
                    }
                    $cart[$goods_id] = $num;
                    //把数量和商品id保存到cookie中
                    $cookies = \Yii::$app->response->cookies;//实例化组件
                    //创建对象并传参
                    $cookie = new Cookie([
                        'name'=>'cart',
                        'value'=>serialize($cart),
                    ]);
                    //保存到cookie
                    $cookies->add($cookie);*/
                    \Yii::$app->CartCookieHandler->updateCart($goods_id,$num)->save();
                    return 'success';
                }else{
                    $model = Cart::findOne(['goods_id'=>$goods_id]);
                    $model->count = $num;
                    $model->save();
                    return 'success';
                }
            break;



            case 'del':
                $goods_id = \Yii::$app->request->post('goods_id');
                if(\Yii::$app->user->isGuest) {
                    /*$cookies = \Yii::$app->request->cookies; //实例化cookie
                    $data = $cookies->get('cart'); //取出cookie中的cart
                    //判断值是否存在
                    if ($data == null) {
                        $cart = [];//给一个空数组
                    } else {
                        $cart = unserialize($data->value);//有值,取出并反序列化
                    }
                    unset($cart[$goods_id]);
                    //把数量和商品id保存到cookie中
                    $cookies = \Yii::$app->response->cookies;//实例化组件
                    //创建对象并传参
                    $cookie = new Cookie([
                        'name'=>'cart',
                        'value'=>serialize($cart),
                    ]);
                    //保存到cookie
                    $cookies->add($cookie);*/
                    \Yii::$app->CartCookieHandler->delCart($goods_id)->save();
                    return 'success';
                }else{
                    $model = Cart::findOne(['goods_id'=>$goods_id]);
                    $model->delete();
                    return 'success';
                }
            break;
        }
    }


    public function actionOrder()
    {

    }

}