<?
$bundle = \frontend\assets\AppAsset::register($this);
echo \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '../site/index-category-item',
//    'itemView' => 'item-product',
    'options' => [
        'tag' => 'div',
        'class' => 'product-lister-outer',
        'id' => '',
    ],
    'layout' => "<div class='row someproduct'>{items}</div>
{summary}
<nav aria-label=\"Page navigation\">
\n{pager}
    <div class=\"clearfix\"></div>
</nav>

",
    'itemOptions' => [
        'tag' => 'div',
        'class' => 'col-md-4 col-sm-6 colum',
    ],
    'summary' => '<input type="hidden" id="summary" value="{totalCount}">',
    'summaryOptions' => [
        'tag' => 'span',
        'class' => 'my-summary'
    ],


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

]);
?>