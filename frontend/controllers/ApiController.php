<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/18
 * Time: 11:34
 */

namespace frontend\controllers;


use frontend\models\Member;
use yii\web\Controller;

class ApiController extends Controller
{
    public function actionLogin()
    {
        //接收请求参数
       $username = \Yii::$app->request->get('username');
       $pwd = \Yii::$app->request->get('pwd');
        //根据用户名查找数据
       $member = Member::findOne(['username'=>$username]);
        //定义返回数据
        $data = [
            'success'=>false,
            'errorMsg'=>'',
            'result'=>''
        ];
        //判断数据是否存在
        if($member){
            //验证密码
            \Yii::$app->security->validatePassword($pwd,$member->password);
            //登录
            \Yii::$app->user->login($member);
            //构造返回数据
            $data['success'] =true;
            $data['errorMsg'] ='';
            $data['result'] = [
                'id'=>$member->id,
                "userName"=> $member->username,
                "userIcon"=> \Yii::getAlias('@web')."images/acer.gif.",
                "waitPayCount"=> 1,
                "waitReceiveCount"=> 1,
                "userLevel"=> 1
            ];
        }
        //返回
        return json_encode($data);
    }

    public function actionSeckill()
    {
    /*
     *  adKind: required (integer)
     *   广告类型(1导航banner，2广告banner)
     */

        $data['success'] =true;
        $data['errorMsg'] ='';
        $data['result'] = [
            "total"=> 55,
            "rows"=> [
                [
                    "allPrice"=> 55,
                    "pointPrice"=> "44",
                    "iconUrl"=>  \Yii::getAlias('@web')."images/acer.gif",
                    "timeLeft"=> 22,
                    "type"=> 1,
                    "productId"=> 1
                ]
            ]
        ];
        return json_encode($data);

    }

    public function actionBanner()
    {
       $adkind = \Yii::$app->request->get('adkind');
        $data['success'] =true;
        $data['errorMsg'] ='';
        $data['result'] = [
            "id"=> 1,
            "type"=> 1,
            "adUrl"=> \Yii::getAlias('@web')."images/acer.gif",
            "webUrl"=> "http://www.baidu.com",//如果是跳转网页类型，则返回网页地址
            "adKind"=> $adkind
        ];
        return json_encode($data);

    }

    public function actionGetYourFav()
    {
        $data['success'] =true;
        $data['errorMsg'] ='';
        $data['result'] = [
                "total"=> 55,
                "rows"=> [
               [
                   "price"=> 55,
                   "name"=> "商品名称",
                   "iconUrl"=>\Yii::getAlias('@web')."images/acer.gif",
                   "productId"=> 1
               ]
           ]
        ];
        return json_encode($data);

    }

    

}