<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/12
 * Time: 16:03
 */

namespace frontend\controllers;


use backend\models\Goods;
use backend\models\GoodsCategory;
use frontend\models\Cart;
use yii\web\Controller;

class GoodsController extends Controller
{
    public $layout = 'goods';
    public function actionGoods($id)
    {

        $cart = new Cart();
        $models = Goods::findOne(['id'=>$id]);
        $cates = GoodsCategory::findAll(['parent_id'=>$id]);
        //商品上级分类信息
        return $this->render('goods',['models'=>$models,'cart'=>$cart,'cates'=>$cates]);
    }
}