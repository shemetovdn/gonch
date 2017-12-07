<?php
$bundle = \frontend\assets\AppAsset::register($this);
use \frontend\widgets\SvgWidget\SvgWidget;
use yii\helpers\Url;

if(!Yii::$app->session->isActive){Yii::$app->session->open();}
$cart = Yii::$app->session->get('cart');
?>
<div class="hidden-xs hidden-sm product_info">
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
        <div class="column column-3 articul"><?=$model->artikul?></div>
        <div class="column column-4">
            <input type="number"  class="form-control text-center count" value="<?php echo $cart[$model->id]['qty'];?>" data-price="<?=$model->price?>" min="1">
        </div>
        <div class="column column-5 price">
            <span class="price"><?=$model->price?></span> грн
        </div>
        <div class="column column-6 price">
            <span class="cost"><?=$model->price?></span> грн
        </div>
        <div class="column column-7 title hidden-sm">
            <button class="btn btn-danger btn-sm delete_item" ><i class="fa fa-trash-o"></i></button>
        </div>
    </div>
</div>

<div class="visible-sm product_info" >
    <div class="row head visible-sm">
        <div class="column column-1 title"><?=\Yii::t('app', 'Наименование товара')?>:</div>
        <div class="column column-3 title"><?=\Yii::t('app', 'Артикул')?>:</div>
        <div class="column column-4 title"><?=\Yii::t('app', 'Количество')?>:</div>
        <div class="column column-5 title"><?=\Yii::t('app', 'Цена')?>:</div>
        <div class="column column-6 title"><?=\Yii::t('app', 'К оплате')?>:</div>
        <div class="column column-7"></div>
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
        <div class="column column-3 articul"><?=$model->artikul?></div>
        <div class="column column-4">
            <input type="number"  class="form-control text-center count" value="<?php echo $cart[$model->id]['qty'];?>" data-price="<?=$model->price?>" min="1">
        </div>
    </div>

    <div class="row head visible-sm">
        <div class="column column-1 title"></div>
        <div class="column column-3 title"><?=\Yii::t('app', 'Цена')?>:</div>
        <div class="column column-4 title"><?=\Yii::t('app', 'К оплате')?>:</div>
        <div class="column column-5 title"></div>
        <div class="column column-6 title"></div>
        <div class="column column-7"></div>
    </div>

    <div class="row body visible-sm">
        <div class="column column-1"></div>
        <div class="column column-2"></div>
        <div class="column column-3 price">
            <span class="price"><?=$model->price?></span> грн
        </div>
        <div class="column column-4 price">
            <span class="cost"><?=$model->price?></span> грн
        </div>
        <div class="column column-5 price"></div>
        <div class="column column-6 price"></div>
        <div class="column column-7 title">
            <button class="btn btn-danger btn-sm delete_item" ><i class="fa fa-trash-o"></i></button>
        </div>
    </div>
</div>

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
        <div class="column column-3 title"><?=\Yii::t('app', 'Артикул')?>:</div>
        <div class="column column-4 title"><?=\Yii::t('app', 'Количество')?>:</div>
        <div class="column column-7"></div>
    </div>

    <div class="row body">
        <div class="column column-3 articul"><?=$model->artikul?></div>
        <div class="column column-4">
            <input type="number" class="form-control text-center count" value="<?php echo $cart[$model->id]['qty'];?>" data-price="<?=$model->price?>" min="1">
        </div>
    </div>


    <div class="row head">
        <div class="column column-5 title"><?=\Yii::t('app', 'Цена')?>:</div>
        <div class="column column-6 title"><?=\Yii::t('app', 'К оплате')?>:</div>
        <div class="column column-7"></div>
    </div>

    <div class="row body">
        <div class="column column-5 price">
            <span class="price"><?=$model->price?></span> грн
        </div>
        <div class="column column-6 price">
            <span class="cost"><?=$model->price?></span> грн
        </div>
        <div class="column column-7 title hidden-sm">
            <button class="btn btn-danger btn-sm delete_item" ><i class="fa fa-trash-o"></i></button>
        </div>
    </div>
</div>

