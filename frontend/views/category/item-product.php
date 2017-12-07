<?php
$bundle = \frontend\assets\AppAsset::register($this);
use \frontend\widgets\SvgWidget\SvgWidget;
?>
<div class="text">
<a href="<?php echo $model->getUrl();?>"><?php echo $model->getMultiLang('title');?></a>
</div>
<div class="img-product">
    <img src="<?php echo $model->image->getUrl();?>" alt="" />
</div>
<div class="block-price"><?php echo number_format($model->price, 0, '', ' ');?> грн</div>
<div class="line"></div>
<div class="clearfix"></div>
<div class="boot-block">
    <div class="left-part">
        <div class="heart" data_product_id="<?php echo $model->id;?>" data_user_id="<?php echo Yii::$app->user->id;?>"></div>
        <div class="plus"><?=SvgWidget::getSvgIcon('+')?></div>
        <div class="clearfix"></div>
    </div>
    <div class="right-part">
        <button class="buyb" data-id="<?php echo $model->id;?>"><?=\Yii::t('app', 'В корзину')?></button>
        <?php if($model->sale != 0){?>
            <div class="sales pink">Распродажа <?=\Yii::t('app', 'Распродажа')?></div>
        <?php }?>
    </div>
    <div class="clearfix"></div>
</div>


