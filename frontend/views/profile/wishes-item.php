<?php
use \frontend\widgets\SvgWidget\SvgWidget;
use yii\web\View;
$bundle = \frontend\assets\ImageAsset::register($this);
$this->registerJs("
    $('.scroll-container').mCustomScrollbar({ 
        theme:'them-gonchar'        
    });
", View::POS_READY);
?>
<div class="thisblock whith-desc-list">
<!--<div class="close remove_from_wishlist" style="margin-right: 5px;" data-product-id="--><?php //echo $model->id;?><!--">x</div>-->
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
        <?php if($model->sale == 0 && !empty($model->old_price)){?>
            <div class="old_price"><?php echo number_format($model->old_price, 0, '', ' ');?> грн</div>
        <?php }?>
        <div class="line"></div>
        <div class="clearfix"></div>
    </a>
    <div class="boot-block">
        <div class="left-part">
            <div class="remove_from_wishlist" data-product-id="<?php echo $model->id;?>"></div>
            <div class="plus"><?=SvgWidget::getSvgIcon('+')?></div>
            <div class="clearfix"></div>
        </div>
        <div class="right-part">
            <button class="buyb"  data-availability="<?php echo $model->availability;?>" data-id="<?php echo $model->id;?>"  data-price="<?php echo $model->price;?>"  data-category-href="<?php echo \yii\helpers\Url::to("/category/".$model->category->href)?>"><?=\Yii::t('app', 'В корзину')?></button>
            <?php if($model->sale != 0){?>
                <div class="sales pink"> <?=\Yii::t('app', 'Распродажа')?></div>
            <?php }?>
            <?php if($model->sale == 0 && !empty($model->old_price)){?>
                <div class="sales green">-<?=$model->discountRate?>%</div>
            <?php }?>
        </div>
        <div class="clearfix"></div>
    </div>
    <div id="hidden" class="popupproduct desc-list">
        <div class="row">
            <div class="col-md-4 col-sm-6 colum-1">
                <div class="text"><?php echo $model->getMultiLang('title');?></div>
                <div class="img-product">
                    <img src="<?php echo $model->image->getUrl();?>" alt="" />
                </div>
                <div class="dev-price"><span><?php echo $model->price;?> грн</span></div>
            </div>
            <div class="col-md-8 col-sm-6 colum-2">
                <div class="scroll-container">

                    <? if($model->description != ''){?>
                        <div class="dev-desc-item">
                            <div class="dev-desc-title">
                                <span>Описание товара</span>
                            </div>
                            <div class="dev-desc-text">
                                <?=$model->description?>
                            </div>
                        </div>
                    <?}?>
                    <div class="dev-desc-item">
                        <div class="dev-desc-title">
                            <span>характеристики</span>
                        </div>
                        <div class="dev-desc-text">
                            <?php if(!empty($model->productParametrs)){
                                foreach($model->productParametrs as $key=>$value){?>
                                    <?php if(!empty($value->getProdParam($model->id)->val)){?>
                                        <div class="row dev-properties-box">
                                            <div class="col-sm-4 dev-title">
                                                <?php echo $value->getProdParam($model->id)->param->getMultiLang('title');?>:
                                            </div>
                                            <div class="col-sm-8 dev-desc">
                                                <?php echo $value->getProdParam($model->id)->val;?>
                                            </div>
                                        </div>
                                    <?php }?>
                                <?php }
                            }?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-sm-6 colum-icons">
                <div class="black-box">
                    <div class="remove_from_wishlist" data-product-id="<?php echo $model->id;?>"></div>
<!--                    <div class="remove_from_wishlist" data-product-id="--><?php //echo $model->id;?><!--">--><?//=SvgWidget::getSvgIcon('X')?><!--</div>-->
                    <div class="minus"><?=SvgWidget::getSvgIcon('-')?></div>
                </div>
            </div>
            <div class="col-md-8 col-sm-6 colum-to-cart">
                <button class="buyb"   data-availability="<?php echo $model->availability;?>" data-id="<?php echo $model->id;?>"  data-price="<?php echo $model->price;?>"  data-category-href="<?php echo \yii\helpers\Url::to("/category/".$model->category->href)?>"><?=\Yii::t('app', 'В корзину')?></button>
            </div>
        </div>
    </div>

</div>