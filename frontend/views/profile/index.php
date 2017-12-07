<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;


$bundle = \frontend\assets\AppAsset::register($this);
$novaPoshta = new \backend\modules\orders\models\NovaPoshta();
$this->title = \Yii::t('app', 'Личный кабинет');
?>
<!--content for site -->
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo Url::to("site/index")?>"><?=\Yii::t('app', 'Главная')?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo Url::to("profile/index")?>"><?=\Yii::t('app', 'Личный кабинет')?></a></li>
    <li class="breadcrumb-item active"><?=\Yii::t('app', 'Настройки')?></li>
</ol>
<div class="somelinecontent"></div>
<div class="name-page"><?=\Yii::t('app', 'Личный кабинет')?></div>
<div class="clearfix"></div>
<!--<div>-->
<!--    <a href="--><?php //echo Url::to("/profile/wishes")?><!--">--><?//=\Yii::t('app', 'Список желаний')?><!--</a>-->
<!--</div>-->
<div class="somelinecontent"></div>
<div class="row checkoutstyle">
    <? $form=ActiveForm::begin([
        'enableClientValidation' => true,
        'enableAjaxValidation' => true,
        'id' => 'profile_form',
    ]); ?>
        <div class="col-md-4 col-sm-6">
            <div class="name-title"><?=\Yii::t('app', 'Общие данные')?></div>
            <div class="form-group">

                <?=$form
                    ->field($formModel,'username',[
                        'options'=>[
                        ]
                    ])
                    ->textInput([
                        'placeholder'=>\Yii::t('app', 'Имя пользователя')
                    ])->label(\Yii::t('app', 'Имя пользователя').":");
                ?>
            </div>
            <div class="form-group">

                <?=$form
                    ->field($formModel,'first_name',[
                        'options'=>[
                        ]
                    ])
                    ->textInput([
                    ])->label(\Yii::t('app', 'Имя').":");
                ?>
            </div>
            <div class="form-group">
                <?=$form
                    ->field($formModel,'last_name',[
                        'options'=>[
                        ]
                    ])
                    ->textInput([
                    ])->label(\Yii::t('app', 'Фамилия').":");
                ?>
            </div>
            <div class="form-group">
                <?=$form
                    ->field($formModel,'email',[
                        'options'=>[
                        ]
                    ])
                    ->textInput([
                    ])->label(\Yii::t('app', 'Электронная почта').":");
                ?>
            </div>
            <div class="form-group">
                <?=$form
                    ->field($formModel,'phone',[
                        'options'=>[
                        ]
                    ])
                    ->textInput([
                            'placeholder' => '+380 ( 12 ) 345 - 67 - 89'
                    ])->label(\Yii::t('app', 'Номер телефона').":");
                ?>
            </div>
            <div class="form-group">
                <?=$form
                    ->field($formModel,'city',[
                        'options'=>[
                        ]
                    ])
                    ->textInput([
                        'placeholder' => \Yii::t('app', 'Введите населенный пункт')
                    ])->label(\Yii::t('app', 'Город').":");
                ?>

<!--                --><?//= $form
//                    ->field($formModel, 'city',['options'=>['class'=>'']])
//                    ->dropDownList(
//                        \yii\helpers\ArrayHelper::merge(
//                            [0 => \Yii::t('app', 'Выберите населенный пункт')],
//                            $novaPoshta->getAllCities()),
//                        [
//                            'class' => 'form-control'
//                        ]
//                    )
//                    ->label(false);
//                ?>
            </div>

        </div>
    <?php if(empty($formModel->service)){?>
        <div class="col-md-4 col-sm-6">
            <div class="name-title"><?=\Yii::t('app', 'Безопасность')?></div>
            <div class="form-group">
                <?=$form
                    ->field($formModel,'old_password',[
                        'options'=>[
                        ]
                    ])
                    ->passwordInput([
                        'placeholder'=>\Yii::t('app', 'Введите свой пароль')
                    ])->label(\Yii::t('app', 'Старый пароль').":");
                ?>
            </div>
            <div class="form-group">
                <?=$form
                    ->field($formModel,'new_password',[
                        'options'=>[
                        ]
                    ])
                    ->passwordInput([

                    ])->label(\Yii::t('app', 'Придумайте новый пароль').":");
                ?>
            </div>
            <div class="form-group">
                <?=$form
                    ->field($formModel,'confirm_password',[
                        'options'=>[
                        ]
                    ])
                    ->passwordInput([

                    ])->label(\Yii::t('app', 'Подтвердите пароль').":");
                ?>
            </div>
        </div>
    <?}?>
    <div class="col-sm-12 visible-sm"></div>
        <div class="col-md-4 col-sm-6">
            <div class="name-title"><?=\Yii::t('app', 'Подписка')?></div>
            <div class="notification"><?=\Yii::t('app', 'Уведомления по электронной почте')?>:</div>
            <div class="notification-2">
                <?=\Yii::t('app', 'Подписка на рассылку уведомлений
                о наших новостях, акциях и скидках.')?>
                <br><br>
                <?=\Yii::t('app', 'Хотели бы Вы получать письма?')?>

            </div>

            <div class="dev-radiolist-1">
                <?= $form->field($formModel, 'subscribe')->radioList(['1' => 'Да', '0' => 'Нет'])->label(false) ?>
            </div>

        </div>
        <div class="clearfix"></div>
        <div class="col-md-offset-4 col-md-4 col-sm-6">
            <button class="btn-cust hvr-shutter-in-horizontal dev-button-1" type="reset">
                <?=\Yii::t('app', 'ОТМЕНИТЬ')?>
            </button>
        </div>
        <div class="col-md-4 col-sm-6">
            <?=\yii\helpers\Html::submitButton(\Yii::t('app', 'СОХРАНИТЬ'),['class'=>'btn-cust hvr-shutter-in-horizontal'])?>
        </div>
    <? \yii\widgets\ActiveForm::end();?>
</div>
</div>
