<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article_category".
 *
 * @property string $id
 * @property string $name
 * @property string $intro
 * @property integer $status
 * @property integer $sort
 * @property integer $is_help
 */
class ArticleCategory extends \yii\db\ActiveRecord
{

    public static $status_options=[1=>'正常',0=>'隐藏','-1'=>'删除'];
    public static $help=[1=>'帮助',0=>'不帮助'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['intro'], 'string'],
            [['status', 'sort', 'is_help'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '分类名',
            'intro' => '简介',
            'status' => '状态',
            'sort' => '排序',
            'is_help' => '帮助信息',
        ];
    }

    public function getChildren(){
        return $this->hasMany(Article::className(),['article_category_id'=>'id']);
    }
}
