<?php
use \frontend\widgets\SvgWidget\SvgWidget;
$bundle = \frontend\assets\ImageAsset::register($this);

?>

<div class="text">
    <a href="<?php echo $model->getUrl();?>">
        <?php echo $model->getMultiLang('title');?>
    </a>
</div>
<a href="<?php echo $model->getUrl();?>">
<div class="img-product">

        <img src="<?php echo $model->image->getUrl();?>" alt="" />

</div>

<div class="block-price"><?php echo $model->price;?> грн</div>
<div class="line"></div>
<div class="clearfix"></div>
</a>
<div class="boot-block">
    <div class="left-part">
        <div class="heart" data_product_id="<?php echo $model->id;?>" data_user_id="<?php echo Yii::$app->user->id;?>"></div>
        <div class="plus"><?=SvgWidget::getSvgIcon('+')?></div>
        <div class="clearfix"></div>
    </div>
    <div class="right-part">
        <button class="buyb" data-id="<?php echo $model->id;?>"><?=\Yii::t('app', 'В корзину')?></button>
        <?php if($model->sale != 0){?>
            <div class="sales pink"> <?=\Yii::t('app', 'Распродажа')?></div>
        <?php }?>
    </div>
    <div class="clearfix"></div>
</div>


<div id="hidden" class="popupproduct desc-list">
    <div class="thisblock" style="margin: 0;">
        <div class="text"><?php echo $model->getMultiLang('title');?></div>
        <div class="img-product">
            <img src="<?php echo $model->image->getUrl();?>" alt="" />
        </div>
        <div class="block-price"><?php echo $model->price;?></div>
        <div class="line"></div>
        <div class="clearfix"></div>
        <div class="boot-block">
            <div class="left-part">
                <div class="heart"></div>
                <div class="minus"><?=SvgWidget::getSvgIcon('-')?></div>
                <div class="clearfix"></div>
            </div>
            <div class="right-part">
                <?php if($model->sale != 0){?>
                    <div class="sales pink">Распродажа</div>
                <?php }?>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="block-informationprodukt">
        <div class="padl">
            <? if($model->description != ''){?>
                <div class="opisanie">
                    <span>Описание товара</span>
                </div>
                <?=$model->description?>
            <?}?>
            <div class="opisanie">
                <span>характеристики</span>
            </div>

            <?php if(!empty($model->parametrs)){
                foreach($model->parametrs as $key => $value){?>
                    <div class="row">
                        <div class="col-md-4 col-xs-6">
                            <div class="text-1"><?php echo $value->param->getMultiLang('title');?>:</div>
                        </div>
                        <div class="col-md-4 col-xs-6">
                            <div class="text-2"><?php echo $value->val;?></div>
                        </div>
                    </div>
                <?php }}?>
        </div>
        <button class="buyb">В корзину</button>
    </div>
    <div class="clearfix"></div>
</div>