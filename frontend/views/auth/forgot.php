<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>


<div class="login-page">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo Url::to('/site/index')?>"><?=\Yii::t('app', 'Главная')?></a></li>
        <li class="breadcrumb-item active"><?=\Yii::t('app', 'Забыли пароль?')?></li>
    </ol>
    <div class="somelinecontent"></div>
    <div class="row">
        <div class="col-sm-8">
            <div class="name-page"><?=\Yii::t('app', 'Забыли пароль?')?></div>
        </div>
        <div class="col-sm-4 text-right">
            <a data-dialog="somedialog-2" class="sign">
                <?=\Yii::t('app', 'Зарегистрироваться')?>
            </a>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="somelinecontent"></div>


    <div class="clearfix" style="height: 40px;"></div>
    <?php $form =ActiveForm::begin(
        [
            'action'=>['auth/forgot'],
            'id'=>'main_login_form',
            'options'=>['class'=>"col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2 text-center"],
            'enableClientValidation'=>true,
        ]
    );?>

    <?= $form->field($forgotPasswordForm, 'email')->textInput(['placeholder'=>"Email"])->label(\Yii::t('app', 'Введите свой адрес электронной почты, чтобы получить новый пароль').':', ['style'=>'text-align:left'])?>


    <div class="row">
        <div class="col-sm-6">
            <button type="submit" class="button-type-1 hvr-shutter-in-horizontal">
                <?=\Yii::t('app', 'СБРОСИТЬ ПАРОЛЬ')?>
            </button>
        </div>
        <div class="col-sm-6 text-right">
            <a href="<?=\yii\helpers\Url::to(['auth/login'])?>" class="forgotpass">
                <?=\Yii::t('app', 'На страницу входа')?>
            </a>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<!--<div style="clear: both; height: 40px;"></div>-->
<!---->
<!--        <div class="container">-->
<!--            <div class="bgwhite">-->
<!--                <div class="banner-login">-->
<!--                    <div class="positionblock">-->
<!--                        <div class="titlepage">MY ACCOUNT</div>-->
<!--                        <hr/>-->
<!--                        <div class="acc">LOG IN TO ACCESS YOUR ACCOUNT.</div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="loginpadding">-->
<!--                    <div class="log">FORGOT PASSWORD</div>-->
<!--                    <div class="clearfix"></div>-->
<!--                    <div class="redline"></div>-->
<!--                    --><?php //$form =ActiveForm::begin(
//                        [
//                            'action'=>['auth/forgot-password'],
//                            'id'=>'main_login_form',
//                            'options'=>['class'=>"col-sm-6 col-sm-offset-3 text-center"],
////                            'enableAjaxValidation' => true
//                        ]
//                    );?>
<!--                        <div class="enteremail">Enter your email to receive a new password:</div>-->
<!--                        --><?//= $form->field($forgotPasswordForm, 'email')->textInput(['placeholder'=>"EMAIL ADDRESS"])->label(false)?>
<!--                        <a href="--><?//=\yii\helpers\Url::to(['auth/login'])?><!--" class="forgotpass">BACK TO LOG IN</a>-->
<!--                        <div class="clearfix"></div>-->
<!--                        <button type="submit" class="btn btn-default">RESET PASSWORD</button>-->
<!--                        --><?php //ActiveForm::end(); ?>
<!--                    <div class="clearfix"></div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->