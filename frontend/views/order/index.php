<!-- 主体部分 start -->
<?php $form =\yii\widgets\ActiveForm::begin();?>

<div class="fillin w990 bc mt15">
    <div class="fillin_hd">
        <h2>填写并核对订单信息</h2>
    </div>
    <div class="fillin_bd">
        <!-- 收货人信息  start-->
        <div class="address">
            <h3>收货人信息 <a href="javascript:;" id="address_modify"></a></h3>
            <div class="address_info">
                <p>
                <?php foreach($models as $address):?>
                    <input type="radio" value="<?=$address->id?>"  name="address_id"/><?=$address->name.' '.$address->tel .' '. $address->province.' '. $address->city.' '. $address->area.' '.  $address->address; ?></p>
                <?php endforeach?>
            </div>

            <div class="address_select none">

            </div>
        </div>
        <!-- 收货人信息  end-->

        <!-- 配送方式 start -->
        <div class="delivery">
            <h3>送货方式 <a href="javascript:;" id="delivery_modify"></a></h3>
            <table>
                <tr>
                    <th>方式</th>
                    <th></th>
                    <th>运费</th>
                </tr>
                <?php foreach(\frontend\models\Order::$sendway as  $id=>$way):?>
                    <tr>
                        <td><input type="radio" name="delivery_id" checked="checked" value="<?=$id?>"/></td>
                        <td><?=$way[0]?></td>
                        <td><?=$way[1]?></td>
                    </tr>
                    <?php endforeach?>
            </table>
            <div class="delivery_info">

            </div>

        </div>
        <!-- 配送方式 end -->

        <!-- 支付方式  start-->
        <div class="pay">
            <h3>支付方式 <a href="javascript:;" id="pay_modify"></a></h3>

            <table>
                <?php foreach(\frontend\models\Order::$payway as $id=>$way):?>
                    <tr class="cur">
                        <input type="radio" name="pay_type_id" checked="checked" value="<?=$id?>"/><?=$way[0].' '.$way[1];?><br>
                    </tr>
                <?php endforeach?>
                <!-- <td class="col1"><input type="radio" name="pay" />货到付款</td>
                 <td class="col2">送货上门后再收款，支持现金、POS机刷卡、支票支付</td>-->
            </table>
        </div>
        <!-- 支付方式  end-->

        <!-- 发票信息 start-->
        <!-- 发票信息 end-->

        <!-- 商品清单 start -->
        <div class="goods">
            <h3>商品清单</h3>
            <table>
                <thead>
                <tr>
                    <th class="col1">商品</th>
                    <th class="col3">价格</th>
                    <th class="col4">数量</th>
                    <th class="col5">小计</th>
                </tr>
                </thead>
                <tbody>
                <?php $num = 0;$sum = 0;//$goods_id=[]?>
                <?php foreach($goods as $good):?>
                <tr>
                    <td class="col1"><a href=""><img src="<?=$good['logo']?>" alt="" /></a>  <strong><a href=""><?=$good['name']?></a></strong></td>
                    <td class="col3"><?=$good['shop_price']?></td>
                    <td class="col4"> <?=$good['num']?></td>
                    <td class="col5"><span><?=$good['shop_price']?></span></td>
                </tr>
                    <?php $num += $good['num'];$sum += $good['shop_price']*$good['num'];//$goods_id[] = $good['id']?>
                <?php endforeach?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="5">
                        <ul>
                            <li>
                                <span><?= $num;?> 件商品，总商品金额：</span>
                                <em class="goodsmoney"><?= $sum?></em>
                            </li>
                            <li>
                                <span>返现：</span>
                                <em>-￥240.00</em>
                            </li>
                            <li>
                                <span>运费：</span>
                                <em class="transmoney">￥10.00</em>
                            </li>
                            <li>
                                <span>应付总额：</span>
                                <em><?= $sum?>.00</em>
                            </li>
                        </ul>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- 商品清单 end -->

    </div>
    <div class="fillin_ft">
        <p>应付总额：<strong class="sumnoney"><?= $sum?>.00</strong></p>
        <input type="hidden" name="sum" value="<?= $sum?>">
        <?=\yii\helpers\Html::submitButton('')?>
    </div>
</div>
<?php \yii\widgets\ActiveForm::end()?>

<!-- 主体部分 end -->
<?php
$js = <<<Js
$(function(){
    //找到配送方式表格里的所以input,添加事件
    $("table:first tbody input").click(function(){
        //取出运费值
        var i = $(this).closest("td").next("td").next("td").text();
        //把值写入到运费
        $(".transmoney").text(i);
        var j = $(".goodsmoney").text();
        var s = parseInt(j) + parseInt(i);
        console.debug(s);
        $(".sumnoney").text(s);
        console.debug($("input:hidden:last"));
        $("input:hidden").text(s);
    });

});
Js;

$this->registerJs($js);
