<?php
use yii\helpers\Url;
use yii\widgets\ListView;

$bundle=\frontend\assets\AppAsset::register($this);
$this->title = $model->title;

$curentUrl = Url::to(['news'. '/' . $model->href], true);
?>
<!--content for site -->
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo Url::to("site/index")?>"><?=\Yii::t('app', 'Главная')?></a></li>
    <li class="breadcrumb-item active"><?php echo $model->getMultiLang('title');?></li>
</ol>
<div class="somelinecontent"></div>
<div class="name-page"><?php echo $model->getMultiLang('title');?></div>
<div class="clearfix"></div>
<div class="somelinecontent"></div>
<div class="custom-for-text">
    <div class="for-img">
        <?php if(!empty($model->image)){?>
<!--            <img src="--><?php //echo $model->image->getUrl();?><!--" alt="" />-->
        <?php }?>
    </div>

    <?php echo $model->getMultiLang('content_page');?>

</div>
<div class="clearfix"></div>
