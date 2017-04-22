<?php

namespace frontend\controllers;

use frontend\models\Address;
use frontend\models\Member;

class AddressController extends \yii\web\Controller
{
    public $layout='address';

    public function actionIndex()
    {

    }

    public function actionAdd()
    {
        $model = new Address();
        $datas = $model->find()->all();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
           // $model->user_id=\Yii::$app->user->id;//当前登录用户的id
            $model->user_id=1;//当前登录用户的id
            $model->save();
            $this->refresh();
        }
        return $this->render('add',['model'=>$model,'datas'=>$datas]);
    }

    public function actionDel($id)
    {
        $model = Address::findOne(['id'=>$id]);
        $model->delete();
        return $this->redirect(['address/add']);


    }

    public function actionEdit($id)
    {
        $model = Address::findOne(['id'=>$id]);
        $datas = $model->find()->all();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->save();
            return $this->redirect(['address/add']);
        }
        return $this->render('add',['model'=>$model,'datas'=>$datas]);
    }

    public function actionStatus($id)
    {
        $model = Address::findOne(['id'=>$id]);
        $model->status=1;
        $model->save();
        return $this->redirect(['address/add']);


    }

}
