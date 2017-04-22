<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/12
 * Time: 9:24
 */

namespace frontend\controllers;


use app\models\Brand;
use backend\models\Goods;
use backend\models\GoodsCategory;
use yii\web\Controller;

class ListController extends Controller
{
    public $layout = 'list';
    public function actionList($id)
    {
        $goods = Goods::find()->where(['goods_category_id'=>$id])->all();
        $model = GoodsCategory::findOne(['id'=>$id]);
        return $this->render('list',['model'=>$model,'goods'=>$goods]);
    }
}