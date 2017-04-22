<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/2
 * Time: 15:56
 */

namespace backend\models;


use backend\models\Admin;
use yii\base\Model;
use yii\web\Cookie;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $code;
    public $cook;


    public function rules()
    {
        return [
            [['username','password'],'required'],
            [['code'],'captcha'],
            [['cook'],'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'username'=>'用户名',
            'password'=>'密码',
            'code'=>'验证码',
            'cook'=>'自动登录',
        ];
    }


    public function login()
    {

        //判断规则
        if($this->validate()){
            //根据用户名查找
            $num=Admin::findOne(['username'=>$this->username]);
            if(!$num){
                $num=Admin::findOne(['email'=>$this->username]);
            }
            //var_dump($num);exit;
            //存在用户
            if($num){
                //验证密码
                if(\Yii::$app->security->validatePassword($this->password,$num->password)){
                    //登录

                    //获得用户登录时间和ip
                    $admin=Admin::findOne(['id'=>$num->id]);
                    $admin->last_login_time=time();
                    $admin->last_login_ip=$_SERVER['REMOTE_ADDR'];
                    $admin->save();

                    \Yii::$app->user->login($num,$this->cook ? time()*3600*24*7 : 0);
//                    var_dump($this->cook);exit;

                 /*   if($this->cook){
                        $cookie = \Yii::$app->response->cookies;
                        $cookie->add(new Cookie([
                            'name'=>'userInfo',
                            'value'=>$num,
                            'expire'=>time()+360,
                        ]));
                    }*/
                    return true;
                }else{
                    $this->addError('password','密码不正确');
                }
            }else{
                $this->addError('username','用户名不存在');
            }
        }
        return false;
    }

}