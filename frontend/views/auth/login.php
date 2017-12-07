<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;

$bundle = \frontend\assets\AppAsset::register($this);
?>

<!-- /#page-content-wrapper -->

<div class="login-page">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo Url::to('/site/index')?>"><?=\Yii::t('app', 'Главная')?></a></li>
        <li class="breadcrumb-item active"><?=\Yii::t('app', 'Личный кабинет')?></li>
    </ol>
    <div class="somelinecontent"></div>
    <div class="row">
        <div class="col-md-8">
            <div class="name-page"><?=\Yii::t('app', 'Личный кабинет')?></div>
        </div>
        <div class="col-md-4 text-right">
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
            'action'=>['auth/login'],
            'id'=>'main_login_form',
            'options'=>[
                'class'=>'col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1',
            ],
        ]
    );?>
    <?= $form->field($loginFormModel, 'return',['options'=>['style'=>'display:none']])->hiddenInput()->label(false) ?>
    <?= $form->field($loginFormModel, 'username')->textInput(['placeholder'=>'EMAIL'])->label(false)?>
    <?= $form->field($loginFormModel, 'password')->passwordInput(['placeholder'=>\Yii::t('app', 'ПАРОЛЬ')])->label(false);?>
    <div class="row">
        <div class="col-sm-6">
            <button type="submit" class="button-type-1 hvr-shutter-in-horizontal">
                <?=\Yii::t('app', 'ВОЙТИ')?>
            </button>
        </div>
        <div class="col-sm-6 text-right">
            <a href="<?=\yii\helpers\Url::to(['auth/forgot'])?>" class="forgotpass">
                <?=\Yii::t('app', 'Забыли пароль?')?>
            </a>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>