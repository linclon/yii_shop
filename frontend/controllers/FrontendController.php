<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11
 * Time: 21:25
 */

namespace frontend\controllers;


use yii\web\Controller;

class FrontendController extends Controller
{

    public $layout = 'frontend';

    public function actionFrontend1()
    {
        return $this->render('frontend1');
    }

}