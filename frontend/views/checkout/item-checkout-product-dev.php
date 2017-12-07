<?php
$bundle = \frontend\assets\AppAsset::register($this);
use \frontend\widgets\SvgWidget\SvgWidget;
if(!Yii::$app->session->isActive){Yii::$app->session->open();}
$cart = Yii::$app->session->get('cart');
?>


<div class="visible-xs product_info">
    <div class="row head">
        <div class="column column-1 title"><?=\Yii::t('app', 'Наименование товара')?>:</div>
    </div>

    <div class="row body">
        <div class="column column-1">
            <a href="<?=$model->getUrl()?>">
                <img src="<?php echo $model->image->getUrl('70x70');?>" alt="" />
            </a>
        </div>
        <div class="column column-2">
            <a href="<?=$model->getUrl()?>" class="name">
                <?php echo $model->getMultiLang('title');?>
            </a>
        </div>
    </div>


    <div class="row head">
        <div class="column column-3 title"><?=\Yii::t('app', 'Количество')?>:</div>
        <div class="column column-4 title"><?=\Yii::t('app', 'Количество')?>:</div>
        <div class="column column-7"></div>
    </div>

    <div class="row body">
        <div class="column column-3 articul">
            <input type="number" class="form-control text-center count" value="<?php echo $cart[$model->id]['qty'];?>" data-price="<?=$model->price?>" min="1">
        </div>
        <div class="column column-4 price">
            <span class="cost"><?=$model->price*$cart[$model->id]['qty'];?></span> грн
        </div>
    </div>

</div>
