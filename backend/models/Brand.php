<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property string $logo
 * @property integer $sort
 * @property integer $status
 */
class Brand extends \yii\db\ActiveRecord
{

    //public $logo_file;//保存图片
    public static $status_options=['-1'=>'删除',0=>'隐藏',1=>'正常'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'sort','logo'], 'required'],
            [['intro'], 'string'],
            [['sort', 'status'], 'integer'],
            [['name'], 'string', 'max' => 50],
          //  [['logo_file'], 'file','extensions'=>['jpg','png','gif'],'skipOnEmpty'=>true],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'intro' => '简介',
            //'logo_file' => 'LOGO',
            'sort' => '排序',
            'status' => '状态',
        ];
    }

    /*
     * 如果是本地返回本地地址
     * 如果是远程返回远程地址
     */
    public function logoUrl()
    {
        if(strpos($this->logo,'http://') === false){
            return '@web'.$this->logo;
        }
        return $this->logo;
    }
}
