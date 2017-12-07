<?php
use \frontend\widgets\SvgWidget\SvgWidget;
use yii\helpers\Url;

$this->registerJs("
                            var dlg = new DialogFx( document.getElementById(\"register_success_modal\") );
                            dlg.toggle();
//                            setTimeout(function () {
//                                dlg.toggle();
//                            }, 2000);
", yii\web\View::POS_LOAD);
?>
<div id="register_success_modal" class="dialog">
    <div class="dialog__overlay"></div>
    <div class="dialog__content">
        <div class="titledialog"><?=\Yii::t("app",'Регистрация')?></div>
        <div class="closebt" style="right: 10px; top: 10px"><button class="action" data-dialog-close><?=SvgWidget::getSvgIcon('X')?></button></div>
        <div class="clearfix"></div>
        <div class="sline"></div>
        <div class="clearfix"></div>

        <p style="margin: 20px 0 0; text-align: center;"><?php echo \Yii::t("app", "Поздравляем, Вы успешно зарегистрировались на сайте. Желаем удачных покупок!")?></p>
<!--        <a href="#" class="category_href">--><?php //echo \Yii::t("app", "Посмотреть похожие")?><!--</a>-->
</div>
</div>
