<?php

namespace frontend\controllers;

use frontend\models\LoginForm;
use frontend\models\Member;
use frontend\models\TelMsg;
use yii\web\Request;


class MemberController extends \yii\web\Controller
{
    //修改布局文件
    public $layout='login';
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
//        $model=new Member();
        return $this->render('index');
    }




       public function actionRegist()
    {
        $model=new Member();

            if($model->load(\Yii::$app->request->post()) && $model->validate()){

                $model->add_time=time();
                $model->password = \Yii::$app->security->generatePasswordHash($model->password);
                $model->authkey = \Yii::$app->security->generateRandomString();
                $model->save(false);


                \Yii::$app->session->setFlash('注册成功!');
                return $this->redirect(['member/index']);
            }

        return $this->render('regist',['model'=>$model]);
    }

    //发送手机验证码
    public function actionSms()
    {
        $tel = \Yii::$app->request->post('tel');
        $code = rand(1000,9999);
        \Yii::$app->session->set('tel_'.$tel,$code);

        /*
         * 防止短信被重复刷取
         *  1.新建保存短信信息的数据表tel_msg  字段：tel times code date send_time
         *  2.判断:没有记录: 发送-->生成一条数据-->保存到tel_msg
         *        有记录:判断是不是今天:是-->判断次数是否大于3-->提示超出限制   不是-->发送-->生成一条新数据
         *  3.网络不好导致短息不一致:
         *      3.1.检查上次发送时间戳距离当前时间是否大于5分钟
         *      3.2检查发送记录表是否有验证码  没有:就生成  有:判断时间是否在5分钟内,若在就用当前验证码
         */
        //根据输入电话号码和当天日期去找数据
       $msg = TelMsg::find()->where(['tel'=>$tel])->andWhere(['date'=>date('Y-m-d',time())])->one();
        if($msg != null){
            //判断次数如果大于三
            if($msg->times - 3 >= 0){
                //提示退出
                \Yii::$app->session->setFlash('danger','今日次数上限,明日再来!');
                //跳转
            }else{//不大于三
                //次数增加1
                $msg->times += 1;
                //保存
                $msg->save(false);
                //判断时间:如果当前时间 - 数据表里的保存时间 < 5分钟
                if(time() - $msg->send_time < 300){
                    //发送数据表的code
                $r = Member::sendMsg($tel,$msg->code);
                    var_dump($r);

                }else{
                    //否则发送新的code
                    $r = Member::sendMsg($tel,$code);
                    var_dump($r);
                }
            }
            //数据不存在
        }else{
            //实例化对象 并赋值
            $tel_msg = new TelMsg();
            $tel_msg->tel = $tel;
            $tel_msg->code = $code;
            $tel_msg->times = 1;
            $tel_msg->date = date('Y-m-d',time());
            $tel_msg->send_time =time();
            $tel_msg->save(false);
            //发送验证码
            $r = Member::sendMsg($tel,$code);
            var_dump($r);
        }
        //发送验证码
     //  $r = Member::sendMsg($tel,$code);
     //   var_dump($r);
    }



    public function actionLogin()
    {
        $model=new LoginForm();
        $request = new Request();
        if($request->isPost){
           $model->load($request->post());
//            var_dump($model->checkLogin());exit;
            if($model->checkLogin()){
              //  $this->refresh();
//                \Yii::$app->session->setFlash('登录成功!');
                  return $this->redirect(['member/index']);
            }
        }
        return $this->render('login',['model'=>$model]);
    }

    public function actionLogout()
    {
        \Yii::$app->user->logout();
    }

    //阿里大于
    public function actionTest()
    {


// 配置信息
        $config = [
            'app_key'    => '23746965',
            'app_secret' => 'ca7d89e01785fa99fce67cfa427a1299',
            // 'sandbox'    => true,  // 是否为沙箱环境，默认false
        ];


// 使用方法一
        $client = new Client(new App($config));
        $req    = new AlibabaAliqinFcSmsNumSend;

        $req->setRecNum('18009006213')
            ->setSmsParam([
                'content' => rand(1000,9999)
            ])
            ->setSmsFreeSignName('云淡风轻近午天')
            ->setSmsTemplateCode('SMS_60855272');

        $resp = $client->execute($req);
        var_dump($resp);
    }
}
