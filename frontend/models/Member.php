<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use Flc\Alidayu\Requests\IRequest;
/**
 * This is the model class for table "member".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $tel
 * @property string $email
 * @property integer $add_time
 * @property integer $last_login_time
 * @property integer $last_login_ip
 * @property integer $status
 * @property integer $authkey
 */
class Member extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $code;
    public $telCode;
    public $rePassword;
    public $agree = true;
//    const SCENARIO_REGIST='regist';


/*    public function scenarios()
    {
        $scenarios=parent::scenarios();
        return ArrayHelper::merge(
            $scenarios,
            [
                self::SCENARIO_REGIST=>['agree','username', 'password', 'tel', 'email','telCode','rePassword']
            ]
        );
    }*/

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'tel', 'email','rePassword'], 'required'],
            [['add_time', 'last_login_time', 'last_login_ip', 'status'], 'integer'],
            [['username', 'password'], 'string', 'max' => 50,'min'=>6],
            [['tel'], 'string', 'max' => 11,'min'=>11],
            [['email'], 'string', 'max' => 30],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['code'], 'captcha'],
            [['rePassword'], 'validatePass'],
            [['agree'], 'boolean'],
            [['telCode'], 'validateSms'],
        ];
    }

    //验证两次输入密码是否一致
    public function validatePass($attribute,$params)
    {
        if($this->password !== $this->rePassword){
            $this->addError($attribute,'两次密码必须一致!');
        }
    }
    //验证手机验证码
    public function validateSms()
    {
        //session中的验证码和提交的验证码做对比
        $code = Yii::$app->session->get('tel_'.$this->tel);
        if($code != $this->telCode){
            $this->addError('telCode','验证码错误');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名：',
            'password' => '密码：',
            'tel' => '电话：',
            'email' => '邮箱：',
            'add_time' => '添加时间',
            'last_login_time' => '最后登录时间',
            'last_login_ip' => '最后登录ip',
            'status' => '状态',
            'code' => '验证码：',
            'telCode' => '验证码：',
            'rePassword' => '确认密码：',
            'agree' => '我已阅读并同意《用户注册协议》',
        ];
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id'=>$id]);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
       return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->authkey;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->authkey == $authKey;
    }

    //发送验证码
    public static function sendMsg($tel,$code)
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

        $req->setRecNum($tel)
            ->setSmsParam([
                'content' =>$code,
            ])
            ->setSmsFreeSignName('云淡风轻近午天')
            ->setSmsTemplateCode('SMS_60855272');

        $resp = $client->execute($req);
        return $resp;
        var_dump($resp);
    }
}
