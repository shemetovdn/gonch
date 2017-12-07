<?php
use \frontend\widgets\SvgWidget\SvgWidget;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
$bundle = \frontend\assets\ImageAsset::register($this);
?>
<div id="somedialog" class="dialog">
    <div class="dialog__overlay"></div>
    <div class="dialog__content">
        <div class="titledialog"><?=\Yii::t('app', 'Вход')?></div>
        <div class="closebt"><button class="action" data-dialog-close><?=SvgWidget::getSvgIcon('X')?></button></div>
        <div class="clearfix"></div>
        <div class="sline"></div>
        <div class="noacc"><?=\Yii::t('app', 'У Вас нет аккаунта?')?><a href="#" data-dialog="somedialog-2"     class="signup"><?=\Yii::t('app', 'Зарегистрироваться')?></a></div>
        <div class="clearfix"></div>

        <?php
        $form=ActiveForm::begin([
//    'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'id' => 'form_login',
            'action' =>'/login'

        ]);
        ?>

            <div class="form-group">
                <?=$form->field($loginFormModel,'username')->textInput([
                    'placeholder'=>\Yii::t('app', "Введите Имя пользователя")
                ])->label(false)?>
            </div>
            <div class="form-group">
                <?=$form->field($loginFormModel,'password')->passwordInput([
                    'placeholder'=>\Yii::t('app', 'Введите пароль')
                ])->label(false)?>
<!--                --><?//=$form->field($loginFormModel,'return')->hiddenInput([
//                        'value' => Url::to()
//                ])->label(false)?>
<!--                <input type="hidden" name="wishes_return" id="product_wishes" value="0">-->
            </div>
            <div class="checkbox pull-left" style="height: 25px;">

                <?= $form->field($loginFormModel, 'rememberMe')->checkbox()->label(false) ?>

            </div>
            <a href="<?php echo Url::to('/auth/forgot');?>" class="forgpass"><?=\Yii::t('app', 'Забыли пароль?')?></a>
            <div class="clearfix"></div>
        <?=\yii\helpers\Html::button(\Yii::t('app', 'ВОЙТИ'), ['type'=>'submit', 'class'=>'btn-cust hvr-shutter-in-horizontal'])?>

        <? ActiveForm::end(); ?>
        <div class="andlogin"><?=\Yii::t('app', 'Другие способы входа')?></div>
        <?php
        if (Yii::$app->getSession()->hasFlash('error')) {
            echo '<div class="alert alert-danger">'.Yii::$app->getSession()->getFlash('error').'</div>';
        }
        ?>
<!--        --><?php //echo \nodge\eauth\Widget::widget(array('action' => 'site/soc-login')); ?>
        <a href="/soc-login?service=facebook" class="logface"><img src="<?php echo $bundle->baseUrl;?>/images/face-icon.png">Facebook</a>
        <a href="/soc-login?service=google_oauth" class="loggoogle"><img src="<?php echo $bundle->baseUrl;?>/images/googleicon.png">Google+</a>
        <div class="clearfix"></div>
    </div>
</div>