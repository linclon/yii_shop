<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/9
 * Time: 16:05
 */

namespace frontend\models;


use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $code;
    public $reMemberMe;

    public function rules()
    {
        return [
            [['username','password'],'required'],
            [['code'],'captcha'],
            [['reMemberMe'],'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username'=>'用户名：',
            'password'=>'密码：',
            'code'=>'验证码：',
            'reMemberMe'=>'记住密码',
        ];
    }

    public function checkLogin()
    {
        if($this->validate()){
            //根据username到数据库查找
            $num=Member::findOne(['username'=>$this->username]);
            //或者根据email查找
            /*if(!$num){
                $num=Member::findOne(['email'=>$this->username]);
            }*/
            //找到数据执行判断密码
            if($num){
                //判断密码hash是否返回为真
                if(\Yii::$app->security->validatePassword($this->password,$num->password)){
                    //
                    $member=Member::findOne(['id'=>$num->id]);
                    $member->last_login_time = time();
                    $member->last_login_ip = ip2long(\Yii::$app->request->userIP);
                    $member->save(false);
                    //登录用户,并判断是否自动登录
                   \Yii::$app->user->login($num,$this->reMemberMe ? 3600*24 : '');
                    \Yii::$app->session->set('id',$member->id);
//var_dump( \Yii::$app->user->id);exit;
                    return true;
                }else{
                    $this->addError('password','密码不正确!');
                }
            }else{
                $this->addError('username','帐号不存在!');
            }
        }
        return false;
    }

}