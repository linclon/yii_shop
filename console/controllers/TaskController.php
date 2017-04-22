<?php
/**
 * 清理过期订单,并且返还库存
 */

namespace console\controllers;


use backend\models\Goods;
use frontend\models\Order;
use frontend\models\OrderDetail;
use Symfony\Component\Console\Helper\Helper;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class TaskController extends \yii\console\Controller
{
    public function actionClear()
    {
        //死循环无线执行
        while(true){
            //最大执行时间设置成无限执行
            set_time_limit(0);
            //找到订单表里过期的订单id
            $orders = Order::find()->select('id')->where(['status'=>1])->andWhere(['<','create_time',time()-3600])->asArray()->all();
            //遍历成一维数组
            $ids = ArrayHelper::map($orders,'id','id');
            echo 'mission success!'."\n\t";
            //所有过期订单该变状态值为0:取消的订单
            Order::updateAll(['status'=>0],'status=1 and create_time < '.time()-3600);
            //再次遍历
            foreach($ids as $id){
                //根据遍历的id到详情表找到所有goodsxinx
                $details = OrderDetail::find()->where(['order_info_id'=>$id])->all();

                //遍历goods信息
                foreach($details as $detail){
                    //取出goods_id  updateAllCounters执行相加
                    Goods::updateAllCounters(['stock'=>$detail->amount],'id='.$detail->goods_id);
                }
            }
            sleep(1);
        }
       /*
        * yii后台添加任务
        */
    }
}