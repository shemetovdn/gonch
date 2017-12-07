<?php
use frontend\assets\AppAsset;
use yii\widgets\Pjax;
use yii\helpers\Url;

    $bundle = AppAsset::register($this);
?>

<!--content for site -->
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo Url::to("site/index")?>"><?=\Yii::t('app', 'Главная')?></a></li>
    <li class="breadcrumb-item active"><?=\Yii::t('app', 'Список Желаний')?></li>
</ol>
<div class="somelinecontent"></div>
<div class="name-page"><?=\Yii::t('app', 'Список Желаний')?></div>
<div class="clearfix"></div>
<div class="somelinecontent"></div>
<?php Pjax::begin(['id' => 'wishesPjax']); ?>
<?php if($dataProvider->getTotalCount() > 0){?>
<div class="product-lister-outer">
    <?=$this->render('wish-list-view',['dataProvider'=>$dataProvider])?>
</div>
<?php }else{?>
    <div> <?=\Yii::t('app', 'Список Желаний пуст')?></div>
<?php }?>
<?php Pjax::end(); ?>

</div>

<!--container end-->
