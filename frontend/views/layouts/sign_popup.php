<?php
use \frontend\widgets\SvgWidget\SvgWidget;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
Url::remember();
?>
<div id="somedialog-2" class="dialog">
    <div class="dialog__overlay"></div>
    <div class="dialog__content">
        <div class="titledialog"><?=\Yii::t('app', 'Регистрация');?></div>
        <div class="closebt"><button class="action" data-dialog-close><?=SvgWidget::getSvgIcon('X')?></button></div>
        <div class="clearfix"></div>
        <div class="sline pad"></div>

<?php
$form=ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'id' => 'form_signup',
    'action' =>'auth/signup'

]);
?>
            <div class="form-group">
                <label><?=\Yii::t('app', 'Как к Вам обращаться')?>:</label>
                <?=$form->field($registerForm,'username')->textInput([
                        'placeholder'=>\Yii::t('app', 'Ваше имя?')
                ])->label(false)?>
            </div>
            <div class="form-group">
                <label><?=\Yii::t('app', 'Электронная почта')?>:</label>
                <?=$form->field($registerForm,'email')->textInput([
                    'placeholder'=>"mail@exemple.com"
                ])->label(false)?>
            </div>
            <div class="form-group">
                <label><?=\Yii::t('app', 'Номер Вашего телефона')?>:</label>
                <?=$form->field($registerForm,'phone')->textInput([
                    'placeholder'=>"+380 ( _ _ ) _ _ _ - _ _ _ _"
                ])->label(false)?>
            </div>
            <div class="form-group">
                <label><?=\Yii::t('app', 'Придумайте пароль')?>:</label>
                <?=$form->field($registerForm,'password')->passwordInput([
                    'placeholder'=>\Yii::t('app', 'Введите пароль')
                ])->label(false)?>
            </div>
            <div class="form-group">
                <label><?=\Yii::t('app', 'Подтвердите пароль')?>:</label>
                <?=$form->field($registerForm,'password_confirmation')->passwordInput([
                    'placeholder'=>\Yii::t('app', 'Введите пароль еще раз')
                ])->label(false)?>
                <input type="hidden" value="<?php echo Url::to();?>" name="return">
            </div>
<!--            <div class="checkbox" style="margin-bottom: 20px;">-->
<!--                <label>-->
<!--                    <input type="checkbox"> Запомнить меня-->
<!--                </label>-->
<!--            </div>-->
            <button type="submit" class="btn-cust hvr-shutter-in-horizontal" data-style="fill" data-horizontal><?=\Yii::t('app', 'ЗАРЕГИСТРИРОВАТЬСЯ')?></button>
        <? ActiveForm::end(); ?>
    </div>
</div>