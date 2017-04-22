<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11
 * Time: 22:06
 */

namespace frontend\widgets;


use backend\models\Article;
use backend\models\ArticleCategory;
use yii\base\Widget;
use yii\helpers\Html;

class FooterWidget extends Widget
{
/*
 * article  article_category
 *
 */
    public function run()
    {

        $html = '';

        $categorys = ArticleCategory::find()->all();
        foreach($categorys as $cates){
            $html .= '<div class="bnav"><h3><b></b> <em>'.$cates->name.'</em></h3><ul>';

            foreach($cates->children as $category){
                $html .= '<li>'.Html::a($category->name,['index/list']).'</li>';
            }
            $html .= '</ul></div>';
        }

        $html = <<<HTML
       <div class="bottomnav w1210 bc mt10">
    {$html}

</div>
HTML;
        return $html;
    }


}