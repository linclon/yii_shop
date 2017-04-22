<?php
/**
 * 注册
 */
?>



<!-- 登录主体部分start -->
<div class="login w990 bc mt10">
    <div class="login_hd">
        <h2>用户注册</h2>
        <b></b>
    </div>
    <div class="login_bd">
        <div class="login_form fl">
<!--            添加form表单-->
            <?php
            $form=\yii\widgets\ActiveForm::begin();
            echo '<ul>';
            echo $form->field($model,'username',
                [
                    'options'=>['tag'=>'li'],
                    'errorOptions'=>['tag'=>'p'],
                    'template'=>"{label}\n{input}\n{hint}\n{error}"
                ]
                )->textInput(['class'=>'txt','placeholder'=>'3-20位字符,由中文、字母、数字和下划线组成']);

            echo $form->field($model,'password',
                [
                    'options'=>['tag'=>'li'],
                    'errorOptions'=>['tag'=>'p'],
                    'template'=>"{label}\n{input}\n{hint}\n{error}"
                ])->passwordInput(['class'=>'txt','placeholder'=>'6-20位字符，可使用字母、数字和符号的组成']);

            echo $form->field($model,'rePassword',
                [
                    'options'=>['tag'=>'li'],
                    'errorOptions'=>['tag'=>'p'],
                    'template'=>"{label}\n{input}\n{hint}\n{error}"
                ]
                )->passwordInput(['class'=>'txt','placeholder'=>'请再次输入密码']);

            echo $form->field($model,'email',
                [
                    'options'=>['tag'=>'li'],
                    'errorOptions'=>['tag'=>'p'],
                    'template'=>"{label}\n{input}\n{hint}\n{error}"
                ]
                )->textInput(['class'=>'txt','placeholder'=>'邮箱必须合法']);

            echo $form->field($model,'tel',
                [
                    'options'=>['tag'=>'li'],
                    'errorOptions'=>['tag'=>'p'],
                    'template'=>"{label}\n{input}\n{hint}\n{error}"
                ]
                )->textInput(['class'=>'txt']);

            $button = '<input type="button" id="get_captcha" value="获取验证码">';

            echo $form->field($model,'telCode',
                [
                    'options'=>['tag'=>'li'],
                    'errorOptions'=>['tag'=>'p'],
                    'template'=>"{label}\n{input} $button\n{hint}\n{error}",
                ]
                )->textInput(['class'=>'txt','placeholder'=>'请输入验证码']);

            echo $form->field($model,'code',
                [
                    'options'=>['tag'=>'li'],
                    'errorOptions'=>['tag'=>'p'],
                    'template'=>"{label}\n{input}\n{hint}\n{error}"
                ]
                )->widget(\yii\captcha\Captcha::className(),
                [
                    'template'=>'<div>
                                    <div >{input}</div>
                                    <div>{image}</div>
                                </div>',
                    'class'=>'txt'
                ]
                );
            echo $form->field($model,'agree'
              /*  [
                    'options'=>['tag'=>'li'],
                    'errorOptions'=>['tag'=>'p'],
                    'template'=>"{label}\n{input}\n{hint}\n{error}"
                ]*/
                )->checkbox();

            echo \yii\helpers\Html::submitButton('',['class'=>'login_btn']);

            echo '</ul>';

            \yii\widgets\ActiveForm::end();
            ?>
        <div class="guide fl">
            <h3>还不是商城用户</h3>
            <p>现在免费注册成为商城用户，便能立刻享受便宜又放心的购物乐趣，心动不如行动，赶紧加入吧!</p>

            <a href="regist.html" class="reg_btn">免费注册 >></a>
        </div>

    </div>
</div>

<?php
$url = \yii\helpers\Url::to(['member/sms']);
$csrf = Yii::$app->request->csrfToken;
$js=<<<EOT
//给按钮添加事件 发送ajax post请求,传入手机号码和csrf验证码,后台返回验证码
    $("#get_captcha").click(function(){
        var tel = $("#member-tel").val(); //获取手机号码
        $.post("{$url}",{"tel":tel,"_csrf-frontend":"{$csrf}"},function(data){
            console.debug(data);
        });


//启用输入框
    $('#captcha').prop('disabled',false);

    var time=30;
    var interval = setInterval(function(){
        time--;
        if(time<=0){
            clearInterval(interval);
            var html = '获取验证码';
            $('#get_captcha').prop('disabled',false);
        } else{
            var html = time + ' 秒后再次获取';
            $('#get_captcha').prop('disabled',true);
        }

        $('#get_captcha').val(html);
    },1000);

    });



EOT;

$this->registerJs($js);


?>
<!-- 登录主体部分end -->
<!--    <script type="text/javascript">
        function bindPhoneNum(){
            //启用输入框
            $('#captcha').prop('disabled',false);

            var time=30;
            var interval = setInterval(function(){
                time--;
                if(time<=0){
                    clearInterval(interval);
                    var html = '获取验证码';
                    $('#get_captcha').prop('disabled',false);
                } else{
                    var html = time + ' 秒后再次获取';
                    $('#get_captcha').prop('disabled',true);
                }

                $('#get_captcha').val(html);
            },1000);
        }
    </script>
-->
