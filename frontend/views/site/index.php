<?php
use yii\helpers\Url;
use yii\widgets\ListView;
use \frontend\widgets\SvgWidget\SvgWidget;
$bundle = \frontend\assets\ImageAsset::register($this);
?>
<!--content for site -->
<?php if(!empty($main_banner)){?>
    <div class="banner-main" style="background-image:url(<?php echo $main_banner->image->getUrl();?>);">
        <div class="block-position">
            <div class="line-m"></div>
            <div class="tex">
                <?php echo $main_banner->getMultiLang('description');?>
                <a href="<?php echo $main_banner->getUrl();?>" class="hvr-shutter-in-horizontal">
                    <?=\Yii::t('app', 'Подробнее')?>
                </a>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <?php }?>

<div class="row customcarusel-1 owl-dropdown-block">
    <?=$this->render('index-products-slider',['model'=>$products_slider])?>
    <div class="owl-carusel-product-list-dropdown-block someproduct">
        <div class="inner"></div>
    </div>
</div>


<!--content for site end-->
<div class="customcarusel-2">
    <?=$this->render('index-discounts',['model'=>$discounts])?>
</div>
<!-- -->
<div class="col-sm-4 text-center">
    <div class="svg-icon-5"></div>
<!--    --><?//=SvgWidget::getSvgIcon('ifo-5')?>
    <div class="titc">Доставка</div>
    <div class="tettc">
        <?=\Yii::t('app', 'Бесплатная доставка по Украине')?>
    </div>
</div>
<div class="col-sm-4 text-center">
    <div class="svg-icon-4"></div>
<!--    --><?//=SvgWidget::getSvgIcon('ifo-4')?>
    <div class="titc">оплата</div>
    <div class="tettc">
        <?=\Yii::t('app', 'Платите так, как Вам удобно')?>
    </div>
</div>
<div class="col-sm-4 text-center">
    <div class="svg-icon-2"></div>
<!--    --><?//=SvgWidget::getSvgIcon('ifo-2')?>
    <div class="titc"><?=\Yii::t('app', 'гарантия')?></div>
    <div class="tettc">
        <?=\Yii::t('app', 'Официальная гарантия')?>
    </div>
</div>
<!-- -->
<div class="clearfix"></div>
<div class="block-lone-title">
    <div class="title"><?php echo $categoryInHome->getMultiLang('title');?></div>
</div>
<!-- -->

<div class="product-lister-outer hidden-xs" data-show-first="2">
    <?=$this->render('index-category',['model'=>$home_products])?>
</div>
<div class="row customcarusel-1 owl-dropdown-block visible-xs" >
    <?=$this->render('index-products-slider',['model'=>$home_products])?>
    <div class="owl-carusel-product-list-dropdown-block someproduct">
        <div class="inner"></div>
    </div>
</div>
<!-- -->
<div class="customcarusel-3">
    <?=$this->render('index-shares',['model'=>$shares])?>
</div>
<!-- -->
<!-- -->
<?php if($recommended->getTotalCount() > 0){?>
<div class="clearfix"></div>
<div class="block-lone-title">
    <div class="title"><?=\Yii::t('app', 'рекомендуемые товары')?></div>
</div>
<!-- -->
<div class="row customcarusel-1 owl-dropdown-block">
    <?=$this->render('index-recommended',['model'=>$recommended])?>
    <div class="owl-carusel-product-list-dropdown-block someproduct">
        <div class="inner"></div>
    </div>
</div>
<?php }?>
<?php if($viewed->getTotalCount() > 0){?>
<div class="clearfix"></div>
<div class="block-lone-title">
    <div class="title"><?=\Yii::t('app', 'просмотренные товары')?></div>
</div>
<!-- -->

<div class="row customcarusel-1 owl-dropdown-block">
    <?=$this->render('index-viewed',['model'=>$viewed])?>
    <div class="owl-carusel-product-list-dropdown-block someproduct">
        <div class="inner"></div>
    </div>
</div>
<?php }?>
<div class="block-lone-title">
    <div class="title"><?=\Yii::t('app', 'Новости')?></div>
</div>
<div data-show-first="2" class="news_list">
    <?=$this->render('index-news',['news'=>$news])?>
</div>
<div class="block-lone-title">
    <div class="title"><?=\Yii::t('app', 'интернет магазин')?></div>
</div>
<!-- -->
<div class="row">
    <div class="col-sm-10 col-xs-9">
        <div class="newstext">
            <?php echo $model->getMultiLang('content_page');?>
        </div>
    </div>
    <div class="col-sm-2 col-xs-3 text-right">
        <span class="toggle_text"></span>
    </div>
</div>
</div>
