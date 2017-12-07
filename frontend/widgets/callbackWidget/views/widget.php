<?php
use \frontend\widgets\SvgWidget\SvgWidget;
$model = Yii::$app->controller->callback;
?>

<div id="callback_modal" class="dialog">
    <div class="dialog__overlay"></div>
    <div class="dialog__content">
        <div class="titledialog"><?php echo \Yii::t("app", 'Обратный звонок')?></div>
        <div class="closebt" style="right: 30px;"><button class="action" data-dialog-close><?=SvgWidget::getSvgIcon('X')?></button></div>
        <div class="clearfix"></div>
        <div class="sline"></div>
        <div class="clearfix" style="height: 20px;"></div>
        <? $form = \yii\bootstrap\ActiveForm::begin([
//            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'id' =>'callback_form',
            'action'=>'/callback'
        ]);
        ?>

        <?= $form->field($model, 'fname')->textInput(['placeholder' => 'Ваше имя'])->label(false)?>
        <?= $form->field($model, 'phone')->textInput(['placeholder'=>"+380 ( _ _ ) _ _ _ - _ _ _ _"])->label(false)?>
        <?=\yii\helpers\Html::button(Yii::t('app','Перезвонить'), ['type'=>'submit', 'class'=>'btn-cust hvr-shutter-in-horizontal'])?>

        <? \yii\bootstrap\ActiveForm::end(); ?>
    </div>
</div>

