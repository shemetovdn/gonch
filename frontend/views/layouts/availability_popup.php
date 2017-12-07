<?php
use \frontend\widgets\SvgWidget\SvgWidget;
use yii\helpers\Url;
?>
<div id="availability_modal" class="dialog">
    <div class="dialog__overlay"></div>
    <div class="dialog__content">
        <div class="titledialog"><?=\Yii::t("app",'Ошибка')?></div>
        <div class="closebt"><button class="action" data-dialog-close><?=SvgWidget::getSvgIcon('X')?></button></div>
        <div class="clearfix"></div>
        <div class="sline"></div>
        <div class="clearfix"></div>

        <p style="margin: 20px 0 0; text-align: center;"><?php echo \Yii::t("app", "Извините, данного товара нет сейчас в наличии")?></p>
<!--        <a href="#" class="category_href">--><?php //echo \Yii::t("app", "Посмотреть похожие")?><!--</a>-->
</div>
</div>
