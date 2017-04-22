<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/17
 * Time: 21:29
 */
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
/* $msg = TelMsg::find()->where(['tel'=>$tel])->andWhere(['date'=>date('Y-m-d',time())])->one();

//        var_dump($tel);
//        var_dump($code);
//        var_dump($msg);exit;
 //数据存在
 if($msg != null){
     //判断次数如果大于三
     if($msg->times > 3){
         //提示退出
         \Yii::$app->session->setFlash('danger','今日次数上限,明日再来!');
         //跳转
     }else{//不大于三
         //次数增加1
         $msg->times += 1;
         //保存
         $msg->save();

         //判断时间:如果当前时间 - 数据表里的保存时间 < 5分钟
         if(time() - $msg->send_time < 300){
             //发送数据表的code
             Member::sendMsg($tel,$msg->code);
         }else{
             //否则发送新的code
             Member::sendMsg($tel,$code);
         }
     }
 //数据不存在
 }else{
     //实例化对象 并赋值
     $tel_msg = new TelMsg();
     $tel_msg->tel = $tel;
     $tel_msg->times = 1;
     $tel_msg->date = date('Y-m-d',time());
     $tel_msg->send_time =time();
     $tel_msg->save();
     //发送验证码
     Member::sendMsg($tel,$code);
 }*/