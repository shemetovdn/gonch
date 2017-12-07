<?php
$bundle = \frontend\assets\AppAsset::register($this);
use \frontend\widgets\SvgWidget\SvgWidget;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
$this->title = $model->getMultiLang('title');

$session = Yii::$app->session;
$id = $model->id;

if(!$session->isActive){$session->open();}
$viewed = $session->get('viewed');
if(is_array($viewed)){
    if (!in_array($id, $viewed)) {
        $viewed[] = $id;
        $session->set('viewed', $viewed);
    }
} else{
    $viewed[] = $id;
    $session->set('viewed', $viewed);
}
$curentUrl = Url::to(['product'. '/' . $model->href], true);

$this->params['breadcrumbs'] = \backend\modules\categories\models\Category::Breadcrumbs($model->category_id);
$this->params['breadcrumbs'][] = [
    'template' => "<li>".$model->getMultiLang('title')."</li>\n",
    'label' =>  $model->getMultiLang('title'),
    'url' => [Url::to()]
];
?>
<?php
echo Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],]);
?>
<div class="somelinecontent"></div>
<div class="name-page"><?php echo $model->category->title?></div>
<div class="clearfix"></div>
<div class="somelinecontent"></div>
<div class="row">
    <div class="col-md-4 col-sm-6">
        <!-- Gallery -->
        <div id="js-gallery" class="gallery">
            <!--Gallery Hero-->
            <div class="gallery__hero">
                <?php if(!empty($model->image)){?>
                <img src="<?php echo $model->image->getUrl('230x200');?>" alt="" />
                <?php }?>
            </div>
            <!--Gallery Hero-->

            <!--Gallery Thumbs-->

            <div class="gallery__thumbs">
                <?php if(!empty($model->images)){?>
                    <?php
                    $count =0;
                    foreach($model->images as $image){?>
                        <?php if($count == 0){?>
                <a href="<?php echo $image->getUrl('230x200');?>" data-gallery="thumb" class="is-active">
                    <img src="<?php echo $image->getUrl('230x200');?>" alt="" />
                </a>
                        <?php }else{?>
                            <a href="<?php echo $image->getUrl('230x200');?>" data-gallery="thumb" >
                                <img src="<?php echo $image->getUrl('230x200');?>" alt="" />
                            </a>
                        <?php }?>
                    <?php $count++; }?>
                <?php }?>
            </div>
            <!--Gallery Thumbs-->
        </div>
        <!-- -->
    </div>
    <div class="col-md-4 col-sm-6">
        <div class="lineprod"></div>
        <div class="nameprod">
            <?php echo $model->getMultiLang('title');?>
        </div>

            <?php
            if($model->availability != 0){?>
            <div class="nal"><?=\Yii::t('app', 'В наличии')?></div>
            <?php }else{?>
                <div class="nal" style="color: red;"><?=\Yii::t('app', 'Нет в наличии')?></div>
            <?php }?>
        <?php if($model->sale == 0 && !empty($model->old_price)){?>
            <div class="old_price"><?php echo number_format($model->old_price, 0, '', ' ');?> грн</div>
        <?php }?>


        <div class="article">Артикул: <?php echo $model->artikul;?></div>
        <div class="block-lone-title">
            <div class="title"><?php echo number_format($model->price, 0, '', ' ');?> грн</div>
        </div>

        <button type="button" class="btn-cust-2 hvr-shutter-in-horizontal buyb " data-availability="<?php echo $model->availability;?>" data-id="<?php echo $model->id;?>"   data-price="<?php echo $model->price;?>"   data-category-href="<?php echo \yii\helpers\Url::to("/category/".$model->category->href)?>"  style="text-transform: uppercase;" ><?=\Yii::t('app', 'В корзину')?></button>

        <span style="cursor: pointer" class="likeprod"  data-product-id="<?php echo $model->id;?>" data-user-id="<?php echo Yii::$app->user->id;?>"><img src="<?php echo $bundle->baseUrl;?>/images/prod-icon-1.png"></span>
        <a href="//plus.google.com/share?app=110&amp;url=<?=$curentUrl?>" class="soc-seti"><img src="<?php echo $bundle->baseUrl;?>/images/prod-icon-3.png"></a>
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?=$curentUrl?>" class="soc-seti"><img src="<?php echo $bundle->baseUrl;?>/images/prod-icon-2.png"></a>
        <div class="pods"><?=\Yii::t('app', 'Поделиться')?></div>
        <div class="clearfix"></div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="sposobdos"><?=\Yii::t('app', 'Способы доставки')?>:</div>
        <div class="dostavka"><img src="<?php echo $bundle->baseUrl;?>/images/prod-icon-4.png"><?=\Yii::t('app', 'Службой доставки «Новая почта»')?></div>
        <div class="dostavka"><img src="<?php echo $bundle->baseUrl;?>/images/prod-icon-5.png"><?=\Yii::t('app', 'Доставка по Вашему адресу')?></div>
        <div class="line-dost"></div>
        <div class="sposobdos"><?=\Yii::t('app', 'Способы оплаты')?>:</div>
        <div class="dostavka"><img src="<?php echo $bundle->baseUrl;?>/images/prod-icon-6.png"><?=\Yii::t('app', 'Наличными при получении')?></div>
        <div class="dostavka"><img src="<?php echo $bundle->baseUrl;?>/images/prod-icon-7.png"><?=\Yii::t('app', 'Безналичный расчет картой на сайте')?></div>
    </div>
</div>
<div class="clearfix"></div>
<div class="linesilverproduct"></div>
<div class="tabcustom">
    <ul class="nav nav-tabs">
        <li><a data-toggle="tab" href="#home"><?=\Yii::t('app', 'Описание товара')?></a></li>
        <li class="active"><a data-toggle="tab" href="#menu1"><?=\Yii::t('app', 'Характеристики товара')?></a></li>
        <li><a data-toggle="tab" href="#menu2"><?=\Yii::t('app', 'Сопутствующие товары')?></a></li>
    </ul>

    <div class="tab-content">
        <div id="home" class="tab-pane fade">
            <?php echo $model->getMultiLang('description');?>
        </div>
        <div id="menu1" class="tab-pane fade in active">
            <?php if(!empty($model->productParametrs)){
                foreach($model->productParametrs as $key=>$value){?>
                    <?php if(!empty($value->getProdParam($model->id)->val)){?>
                        <div class="row">
                            <div class="col-md-4 col-xs-6">
                                <div class="text-1"><?php echo $value->getProdParam($model->id)->param->getMultiLang('title');?>:</div>
                            </div>
                            <div class="col-md-4 col-xs-6">
                                <div class="text-2"><?php echo $value->getProdParam($model->id)->val;?></div>
                            </div>
                        </div>
                    <?php }}}?>
        </div>
        <div id="menu2" class="tab-pane fade">
            <div class="row customcarusel-1 owl-dropdown-block">
                <?=$this->render('index-associated',['model'=>$associated])?>
                <div class="owl-carusel-product-list-dropdown-block someproduct">
                    <div class="inner"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if($recommended->getTotalCount() > 0){?>
<div class="block-lone-title">
    <div class="title"><?=\Yii::t('app', 'рекомендуемые товары')?></div>
</div>
    <div class="product-lister-outer">
        <?=$this->render('list-recommended',['model'=>$recommended])?>
    </div>

<?php }?>
<div class="clearfix"></div>
<?php if($viewed_product->getTotalCount() > 0){?>
<div class="block-lone-title product-viewed-title">
    <div class="title"><?=\Yii::t('app', 'просмотренные товары')?></div>
</div>
<div class="row customcarusel-1 owl-dropdown-block product-viewed-item">
    <?=$this->render('../site/index-viewed',['model'=>$viewed_product])?>
    <div class="owl-carusel-product-list-dropdown-block someproduct">
        <div class="inner"></div>
    </div>
</div>
<?php }?>