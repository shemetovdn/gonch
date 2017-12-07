<?php
use frontend\assets\AppAsset;
use yii\widgets\Pjax;
use yii\helpers\Url;
$this->title = \Yii::t('app', 'Корзина');
    $bundle = AppAsset::register($this);

?>
<!--content for site -->
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo Url::to("site/index")?>"><?=\Yii::t('app', 'Главная')?></a></li>
    <li class="breadcrumb-item active"><?=\Yii::t('app', 'Корзина')?></li>
</ol>
<div class="somelinecontent"></div>
<div class="name-page"><?=\Yii::t('app', 'Корзина')?></div>
<div class="clearfix"></div>
<div class="somelinecontent"></div>
<?php Pjax::begin(['id' => 'cartPjax']); ?>
<?php if($dataProvider->getTotalCount() > 0){?>

    <div class="dev-cart-list">
        <div class="row head hidden-sm hidden-xs">
            <div class="column column-1 title"><?=\Yii::t('app', 'Наименование товара')?>:</div>
            <div class="column column-3 title"><?=\Yii::t('app', 'Артикул')?>:</div>
            <div class="column column-4 title"><?=\Yii::t('app', 'Количество')?>:</div>
            <div class="column column-5 title"><?=\Yii::t('app', 'Цена')?>:</div>
            <div class="column column-6 title"><?=\Yii::t('app', 'К оплате')?>:</div>
            <div class="column column-7"></div>
        </div>
        <?=$this->render('cart-list-view-dev',['dataProvider'=>$dataProvider])?>
    </div>

<?php }else{?>
    <div> <?=\Yii::t('app', 'Ваша корзина пуста')?></div>
<?php }?>
<?php if($dataProvider->getTotalCount() > 0){?>
    <table class="totaltable">
        <tr>
            <td class="n-table-1"></td>
            <td class="n-table-2 text-center finaltotal"><?=\Yii::t('app', 'Итого')?>:<span><span id="totalCost"><?php echo $totalAmount;?></span> грн</span></td>
        </tr>
        <tr>
            <td class="n-table-1"></td>
            <td class="n-table-2 text-center">
                <form action="<?=Url::to(['checkout'])?>">
                    <button class="btn btn-success btn-block hvr-shutter-in-horizontal"><?=\Yii::t('app', 'Оформить заказ')?></button>
                </form>
            </td>
        </tr>
    </table>
<?php }?>
<?php Pjax::end(); ?>

</div>
<!--container end-->
