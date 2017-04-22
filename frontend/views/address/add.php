<div class="content fl ml10">
    <div class="address_hd">
        <h3>收货地址薄</h3>
        <?php foreach($datas as $data):?>
            <dl class="last"> <!-- 最后一个dl 加类last -->
                <dt><?=$data->id?>.<?=$data->name?> <?=$data->province?> <?=$data->city?> <?=$data->area?> <?=$data->address?> <?=$data->tel?> </dt>
                <dd>
                    <a href="<?=\yii\helpers\Url::to(['address/edit','id'=>$data->id])?>">修改</a>
                    <a href="<?=\yii\helpers\Url::to(['address/del','id'=>$data->id])?>">删除</a>
                    <a href="<?=\yii\helpers\Url::to(['address/status','id'=>$data->id])?>">设为默认地址</a>
                </dd>
            </dl>
        <?php endforeach;?>
    </div>

    <div class="address_bd mt10">
        <h4>新增收货地址</h4>
        <?php
        $form =\yii\widgets\ActiveForm::begin();
        echo '<ul>';
        echo $form->field($model,'name',
            [
                'options'=>['tag'=>'li'],
                'errorOptions'=>['tag'=>'p','style'=>'margin-left:60px;margin-top:5px;'],
            ]
        )->textInput(['class'=>'txt','placeholder'=>'请输入收货人']);


        echo '<li style="display: inline-flex"><label for=""> 所在地区：</label>';
        echo $form->field($model,'province',['options'=>['tag'=>false,'template'=>"{input}"]])->dropDownList([''=>'请选择']);
        echo $form->field($model,'city',['options'=>['tag'=>false,'template'=>"{input}"]])->dropDownList([''=>'请选择']);
        echo $form->field($model,'area',['options'=>['tag'=>false,'template'=>"{input}"]])->dropDownList([''=>'请选择']);
        echo '</li>'
        ?>



        <?php
        echo $form->field($model,'address',
            [
                'options'=>['tag'=>'li'],
                'errorOptions'=>['tag'=>'p','style'=>'margin-left:60px;margin-top:5px;'],
            ]
        )->textInput(['class'=>'txt','placeholder'=>'请输入详细地址']);

        echo $form->field($model,'tel',
            [
                'options'=>['tag'=>'li'],
                'errorOptions'=>['tag'=>'p','style'=>'margin-left:60px;margin-top:5px;'],
            ]
        )->textInput(['class'=>'txt','placeholder'=>'请输入联系电话']);

        echo '<li>
                    <label for="">&nbsp;</label>
                    <label><input type="checkbox" name="Address[status]" id="status" class="check" value="1">设为默认地址</label>
                </li>';


        echo \yii\helpers\Html::submitButton('保存',['class'=>'btn','style'=>'margin-left:60px;']);
        echo '</ul>';
        \yii\widgets\ActiveForm::end();

        ?>
    </div>

</div>


<?php
//注册js
//依赖jqery文件
$this->registerJsFile('@web/js/address.js');

$js=<<<EOT
$(function(){
    //1.读取省的数据
    var options = '<option value="">请选择</option>';  //初始化一个option
    $(address).each(function(i,province){   //循环遍历省份数据
        options += '<option>'+province.name+'</option>'; //拼接option
    });
    $("#address-province").html(options);   //添加到省份下拉框中



    //2.读取城市数据
    $("#address-province").change(function(){   //在省份下拉框添加change事件
         var province_name = $(this).val();     //取出事件获得的省份数据
         var options = '<option value="">请选择</option>';     //初始化一个option
             $(address).each(function(i,province){      //循环遍历省份数据
                if(province_name == province.name){     //判断下拉框的省份和遍历的省份相同
                    $(province.city).each(function(j,city){     //遍历当前省份下的城市
                        options += '<option>'+city.name+'</option>';    //拼接城市数据
                    });
                return false;     //判断下拉框的省份和遍历的省份相同时 停止向下查找
                }
             });
    $("#address-city").html(options);   //添加到城市下拉框

    $("#address-area").html('<option value="">请选择</option>');   //清空县选项
    });



    //3.获取地区数据
    $("#address-city").change(function(){   //在城市下拉框添加change事件
        var city_name = $(this).val();      //取出事件获得的城市数据
        var province_name = $("#address-province").val();  //取出事件获得的省份数据
        var options = '<option value="">请选择</option>';      //初始化一个option
        $(address).each(function(i,province){      //循环遍历省份数据
            if(province_name == province.name){    //判断下拉框的省份和遍历的省份相同
                $(province.city).each(function(j,city){     //遍历当前省份下的城市
                    if(city_name == city.name){     //判断下拉框的城市和遍历的城市数据相同
                        $(city.area).each(function(k,area){     //遍历当前城市下的地区数据
                            options += '<option>'+area+'</option>';      //拼接地区数据
                        });
                    return false;    //判断下拉框的城市和遍历的城市数据相同时 停止向下查找
                    }
                });
            }
        });
    $("#address-area").html(options);        //添加到地区下拉框
    });



});
EOT;
//注册js
$this->registerJs($js);


?>

