<?php
    use yii\widgets\ListView;
    use yii\helpers\Url;
    $this->title = \Yii::t('app', 'Скидки');
    $bundle=\frontend\assets\AppAsset::register($this);
?>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo Url::to("site/index")?>"><?=\Yii::t('app', 'Главная')?></a></li>
        <li class="breadcrumb-item active"><?=\Yii::t('app', 'Скидки')?></li>
    </ol>
    <div class="somelinecontent"></div>
    <div class="name-page"><?=\Yii::t('app', 'Скидки')?></div>
    <div class="clearfix"></div>
    <div class="somelinecontent"></div>
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

//    'layout' => "<div class='row'>{items}</div>{summary}
//    <nav aria-label=\"Page navigation\">
//
//\n{pager}
//
//    </nav>
// <div class=\"clearfix\"></div>
//",

    'pager' => [
        'prevPageLabel' => '
                    <img src="'.$bundle->baseUrl.'/images/left-pagination.png" alt="" />
',
        'nextPageLabel' => '<img src="'.$bundle->baseUrl.'/images/right-pagination.png" alt="" />',
//        'class'=>'\frontend\models\LinkPager',

        // Customzing options for pager container tag
        'options' => [
            'class' => "pagination text-center",
        ],
        'linkOptions' => [
            'data-pjax' => "false"
        ]
    ],

])
?>

    </div>
    <!--container end-->
