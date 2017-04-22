<?php

namespace frontend\components;
use yii\web\Cookie;

/**
 * 操作购物车cookie的方法封装
 */
class CartCookieHandler extends \yii\base\Component
{
    //定义属性保存数据
    protected $_cart = [];
    //构造方法 先获得cookie
    public function __construct(array $config=[])
    {
        //实例化
        $cookies = \Yii::$app->request->cookies;
        //传参
        $cookie = $cookies->get('cart');
        //判断(没有值时会报错,给[]避免)
        if($cookie == null){
            $cart = [];
        }else{
            //读取数据并反序列化
            $cart = unserialize($cookie->value);
        }
        //保存到属性
        $this->_cart = $cart;
        //继承父类构造方法
        parent::__construct($config);
    }

    /*
     * getCart
     */
    public function getCart()
    {
        //实例化
        $cookies = \Yii::$app->request->cookies;
        //传参
        $cookie = $cookies->get('cart');
        //判断(没有值时会报错,给[]避免)
        if($cookies == null){
            $cart = [];
        }else{
            //读取数据并反序列化
            $cart = unserialize($cookie->value);
        }
        return $cart;
    }

    /*
     * 添加cookie,传入参数:商品id和数量 初始化数量
     */
    public function addCart($goods_id,$num=1)
    {
        //判断如果cookie有该商品
        if(array_key_exists($goods_id,$this->_cart)){
            //执行累加操作
            $this->_cart[$goods_id] += $num;
        }else{
            //没有该商品执行添加  格式:键(商品id)=>值(数量)
            $this->_cart[$goods_id] = $num;
        }

        return $this;
    }

    /*
     * 更新cookie
     */
    public function updateCart($goods_id,$num=1)
    {
        //格式:键(商品id)=>值(数量)
        $this->_cart[$goods_id] = $num;
        return $this;

    }

    /*
     * 删除cookie
     */
    public function delCart($goods_id)
    {
        //删除商品id
        unset($this->_cart[$goods_id]);
        return $this;

    }

    public function save()
    {
        //开启组件
        $cookies = \Yii::$app->response->cookies;
        //实例化并传参
        $cookie = new Cookie([
            'name' => 'cart',   //name属性为cart
            'value' => serialize($this->_cart), //值为序列化后的值
        ]);
        //执行保存
        $cookies->add($cookie);
    }
}