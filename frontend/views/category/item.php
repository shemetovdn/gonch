<?php
use yii\helpers\Url;
?>

<div class="catalog-img-box">
    <img class="img" src="<?= $model->image->getUrl() ?>" alt="">
    <div class="masca"></div>
    <div class="img-cont">
        <div><span class="colors">+ <span>ЦВЕТА</span></span></div>
        <div>
            <span class="eye"></span>
            <span class="heart"></span>
        </div>
    </div>
</div>
<div class="box-for-desc">
    <div class="view-box">
        <span class="view"><span>101</span></span>
        <span class="like"><span>51</span></span>
    </div>
    <div class="sale-line"><span class="sale">- SALE %</span></div>
    <div class="text-content"><a href="<?php echo Url::to(['product/', 'id' => $model->id]);?>"><?= $model->title; ?></a>
    </div>
    <div class="price-line">
        <span class="old-price">1200</span>
        <span class="real-price"><?php /*echo $model->price;*/?> ГРН</span>
    </div>
</div>