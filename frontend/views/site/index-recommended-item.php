<?php
use \frontend\widgets\SvgWidget\SvgWidget;
$bundle = \frontend\assets\ImageAsset::register($this);
?>
    <div class="item" data-list-triger="<?php echo $model->id?>">
        <div class="thisblock">
            <a href="<?php echo $model->getUrl();?>">
            <div class="text">
                <?php echo $model->getMultiLang('title');?>
            </div>
            <div class="img-product">
                <img src="<?php echo $model->image->getUrl();?>" alt="" />
            </div>
            </a>
            <div class="block-price" style="margin-top: 0"><?php echo $model->price;?></div>
            <div class="line"></div>
            <div class="clearfix"></div>
            <div class="boot-block">
                <div class="left-part">
                    <div class="heart" data_product_id="<?php echo $model->id;?>" data_user_id="<?php echo Yii::$app->user->id;?>"></div>
                    <div class="plus" data-list-triger-id="<?php echo $model->id?>"><?=SvgWidget::getSvgIcon('+')?></div>

                    <div class="clearfix"></div>
                </div>
                <div class="right-part">
                    <button class="buyb" data-availability="<?php echo $model->availability;?>" data-id="<?php echo $model->id;?>" data-category-href="<?php echo \yii\helpers\Url::to("/category/".$model->category->href)?>"><?=\Yii::t('app', 'В корзину')?></button>
                    <?php if($model->sale != 0){?>
                        <div class="sales pink"><?=\Yii::t('app', 'Распродажа')?></div>
                    <?php }?>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>


        <!-- -->
        <div class="popupproduct desc-list" data-list-content="<?php echo $model->id?>">
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
                    <div class="row">
                        <div class="col-md-6 col-xs-6">
                            <div class="text-1">Бренд:</div>
                            <div class="text-1">Размер, мм:</div>
                            <div class="text-1">Назначение:</div>
                            <div class="text-1">Износостойкость:</div>
                            <div class="text-1">Цвет:</div>
                            <div class="text-1">Класс:</div>

                        </div>
                        <div class="col-md-6 col-xs-6">
                            <div class="text-2">Classen</div>
                            <div class="text-2">605x282x8</div>
                            <div class="text-2">Средние нагрузки</div>
                            <div class="text-2">AC4</div>
                            <div class="text-2">светлый бетон</div>
                            <div class="text-2">32</div>
                        </div>
                    </div>
                </div>
                <button class="buyb">В корзину</button>
            </div>
            <div class="clearfix"></div>
        </div>
        <!-- /-->

    </div>
