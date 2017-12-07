<?php
use \frontend\widgets\SvgWidget\SvgWidget;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
$bundle = \frontend\assets\ImageAsset::register($this);
?>
<div id="addToCart_popup" class="dialog">
    <div class="dialog__overlay hide"></div>
    <div class="dialog__content">
        <div class="closebt hide"><button class="action" data-dialog-close><?=SvgWidget::getSvgIcon('X')?></button></div>
        <div class="clearfix"></div>
        <p class="success"><?=\Yii::t('app', 'Товар  успешно добавлен в корзину');?></p>
        <p class="error"><?=\Yii::t('app', 'Товар  уже находится в корзине');?></p>
    </div>
</div>