<?php
/**
 * 添加权限
 */
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'description');
echo \yii\bootstrap\Html::submitButton('提交');
\yii\bootstrap\ActiveForm::end();

