<?php
namespace frontend\widgets;

use backend\models\GoodsCategory;
use yii\base\Widget;
use yii\helpers\Html;

class GoodsCategoryWidget extends Widget
{
    public $expand = false;//是否展开商品分类
    public function run()
    {
        //开启缓存
        $cache = \Yii::$app->cache;
        //指定key
        $key = 'good_categor'.$this->expand;
        //得到缓存
        $html = $cache->get($key);
        //判断存在就返回
        if($html){
            return $html;
        }
        /*
         * 在调用部件时:
         *      有传值:三元运算后,$cat1 = ''  $none = ''   得到首页展示class
         *      没有值:三元运算后,$cat1 = cat1  $none = none    得到非首页class
         */
        $cat1 = $this->expand?'':'cat1';
        $none = $this->expand?'':'none';

        //初始化返回变量
        $html='';
        //找到parnet_id为0的一级节点  --> 在根据一对多关系找它的子节点
        $categoryries = GoodsCategory::find()->where(['parent_id'=>0])->all();
        //循环变量一级节点
        foreach($categoryries as $category){
            //根据页面需求拼接html标签
                $html .= '<div class="cat item1">
                         <h3>'.Html::a($category->name,['list/list','id'=>$category->id]).'<b></b></h3>
                         <div class="cat_detail">';
            //调用模型得到子节点方法得到二级节点
            foreach($category->children as $child){
                //根据页面需求拼接html标签
                $html .= '<dt>'.Html::a($child->name,['list/list','id'=>$child->id]).'</dt>
                          <dd>';
                //调用模型得到子节点方法得到三级节点
                foreach($child->children as $cate){
                    //根据页面需求拼接html标签
                    $html .= Html::a($cate->name,['list/list','id'=>$cate->id]);
                    $html .= '	</dd>
							</dl>';
                }
            }
            //根据页面需求拼接html标签
            $html .= '</div></div>';
        }
        //根据页面需求拼接html标签
        $html = <<<HTML
<div class="category fl {$cat1}"> <!-- 非首页，需要添加cat1类 -->
            <div class="cat_hd">  <!-- 注意，首页在此div上只需要添加cat_hd类，非首页，默认收缩分类时添加上off类，鼠标滑过时展开菜单则将off类换成on类 -->
                <h2>全部商品分类</h2>
                <em></em>
            </div>
            <div class="cat_bd {$none}">
                {$html}
            </div>
        </div>
HTML;
        $cache->set($key,$html,3600*7*24);
        //返回widget
        return $html;

    }

}