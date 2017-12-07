<?php
use yii\helpers\Url;
use yii\widgets\ListView;

$bundle=\frontend\assets\AppAsset::register($this);
$this->title = $article->title;

$curentUrl = Url::to(['news'. '/' . $article->href], true);
?>
<!--content for site -->
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo Url::to("site/index")?>"><?=\Yii::t('app', 'Главная')?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo Url::to("/shares")?>"><?=\Yii::t('app', 'Акции')?></a></li>
    <li class="breadcrumb-item active"><?php echo $article->getMultiLang('title');?></li>
</ol>

<div class="somelinecontent"></div>
<div class="name-page">
    <span><?php echo $article->getMultiLang('title');?></span>
    <a href="<?=Url::to(['shares' . '/' . $article->getNext()->href], true);?>" class="nextnews"><?=Yii::t('app', 'Следующая акция')?><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
</div>
<div class="clearfix"></div>
<div class="somelinecontent"></div>

<div class="custom-for-text">
    <div class="for-img">
        <img src="<?php echo $article->image->getUrl();?>" alt="" />
    </div>
    <?php echo $article->getMultiLang('description');?>

</div>
<!-- -->
<div class="block-lone-title">
    <div class="title"><?=\Yii::t('app', 'Акции')?></div>
</div>
<!-- -->
<?
echo ListView::widget([
    'dataProvider' => $dataProvider,
    'options'=>[
        'class'=>'row',
    ],
    'itemView' => 'item',
    'summary' => false,
    'itemOptions' => [
        'class' => 'col-md-4 col-sm-6'
    ],
])
?>
<div class="clearfix"></div>