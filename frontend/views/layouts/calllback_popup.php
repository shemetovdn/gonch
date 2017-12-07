<?php
use \frontend\widgets\SvgWidget\SvgWidget;
use yii\helpers\Url;
?>
<div id="callback_modal" class="dialog">
    <div class="dialog__overlay"></div>
    <div class="dialog__content">
        <div class="titledialog">Обратный звонок</div>
        <div class="closebt"><button class="action" data-dialog-close><?=SvgWidget::getSvgIcon('X')?></button></div>
        <div class="clearfix"></div>
        <div class="sline"></div>
        <div class="clearfix"></div>
        <? $form = \yii\bootstrap\ActiveForm::begin([
                'id' =>'form',
                'action'=>'/site/submit-form'
        ]); ?>

        <?= $form->field($model, 'fname')->textInput(['placeholder' => 'Ваше имя'])->label(false)?>
        <?= $form->field($model, 'phone')->textInput(['placeholder' => 'Телефон'])->label(false)?>
        <?=\yii\helpers\Html::button('Перезвонить', ['type'=>'submit', 'class'=>'btn-cust hvr-shutter-in-horizontal pulse'])?>

        <? \yii\bootstrap\ActiveForm::end(); ?>
</div>
</div>
