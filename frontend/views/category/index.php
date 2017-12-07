<?php
/**
 * Created by PhpStorm.
 ** User: TrickTrick alexeymarkov.x7@gmail.com
 *** Date: 27-Mar-17
 **** Time: 14:26
 */
$bundle = \frontend\assets\AppAsset::register($this);
use \frontend\widgets\SvgWidget\SvgWidget;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
$this->registerJs('

$(".sortbl").change(function(){
    var id = $(this).val();
    var url_to = "/category/'.$model->href.'/"+id;

    $.pjax.reload({url: url_to,"container":"#catalogPjax", history:true,type: "POST", data: "id="+id, timeout: 10000}).done(function() {
        ShowProduct();
    });
})



', yii\web\View::POS_READY);

$this->title = $model->getMultiLang('title');
?>
<?php
    if($model->parent_id != 0){
        $parent_cat = \backend\modules\categories\models\Category::findOne($model->parent_id);

        $this->params['breadcrumbs'] = \backend\modules\categories\models\Category::Breadcrumbs($model->parent_id);
        $this->params['breadcrumbs'][] = [
            'template' => "<li>".$model->getMultiLang('title')."</li>\n",
            'label' =>  $model->getMultiLang('title'),
            'url' => [Url::to()]
        ];
    }else{
        $this->params['breadcrumbs'][] = [
            'template' => "<li>".$model->getMultiLang('title')."</li>\n",
            'label' =>  $model->getMultiLang('title'),
            'url' => [Url::to()]
        ];
    }


?>
<!--content for site -->
<?php
echo Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],]);
?>

<div class="somelinecontent"></div>
<div class="name-page"><span><?php echo $model->getMultiLang('title')?></span>

    <div class="visible-xs" style="clear: both; height: 5px;"></div>
    <div class="sortpr" data-show="list"></div>
    <div class="sortpr active" data-show="grid"></div>
    <select class="sortbl">
        <option value="">
            <?=\Yii::t('app', 'Сортировка')?></option>
        <option value="1"><?=\Yii::t('app', 'Сортировка')?> <?=\Yii::t('app', 'по увеличению цены')?></option>
        <option value="2"><?=\Yii::t('app', 'Сортировка')?> <?=\Yii::t('app', 'по убыванию цены')?></option>
    </select>
</div>

<div class="clearfix"></div>
<div class="somelinecontent"></div>

    <?php Pjax::begin(['id' => 'catalogPjax']); ?>
    <?=$this->render('catalog-list-view',['dataProvider'=>$dataProvider])?>
    <?php Pjax::end(); ?>
<!-- -->
<div class="clearfix"></div>
<div class="block-lone-title">
    <div class="title"><?php echo $model->getMultiLang('subtitle');?></div>
</div>
<!-- -->
<div class="row">
    <div class="col-sm-10">
        <div class="newstext">
<?php echo $model->getMultiLang('description');?>
        </div>
        <style>
            .newstext{
                max-height:100%;
                overflow: hidden;
                transition: 1s easy;
            }

        </style>
    </div>
    <div class="col-sm-2 text-right">
        <a href="#"  class="toggle_text">
            <img src="<?=$bundle->baseUrl?>/images/img-11.png" alt="" />
        </a>
    </div>
</div>
</div>
