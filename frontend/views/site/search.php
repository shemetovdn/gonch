<?php
use yii\helpers\Url;
use yii\widgets\ListView;
use \frontend\widgets\SvgWidget\SvgWidget;
use yii\widgets\Pjax;

$this->registerJs('

            function ShowProduct(){
                var view = $(".sortpr.active").attr("data-show");

                console.log(view);
                if(view == "list"){
                    $("#catalogPjax .someproduct").addClass("line-bloke");
                }
                if(view == "grid"){
                    $("#catalogPjax .someproduct").removeClass("line-bloke");
                }
            }
            $(".sortpr").click(function(){
                $(".sortpr").removeClass("active");
                $(this).addClass("active");
                ShowProduct();
            })


$(".sortbl").change(function(){
    var id = $(this).val();
    var url_to = "/search";

    $.pjax.reload({url: url_to, "container":"#catalogPjax", history:true,type: "POST", data: {"SearchForm[q]": "'.$request.'", "id": id}, timeout: 1000}).done(function() {
        ShowProduct();
    });
})

', yii\web\View::POS_READY);


$bundle = \frontend\assets\ImageAsset::register($this);
?>
<!--content for site -->

<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo Url::to(['site/index'])?>"><?=\Yii::t('app', 'Главная')?></a></li>
    <li class="breadcrumb-item active"><?=\Yii::t('app', 'Поиск')?></li>
</ol>

<div class="somelinecontent"></div>
<div class="name-page"><?//php echo $model->getMultiLang('title')?>Поиск <?=$request?></div>
<div class="sortpr" data-show="list"><?=SvgWidget::getSvgIcon('ifo-1')?></div>
<div class="sortpr active" data-show="grid"><?=SvgWidget::getSvgIcon('ifo-3')?></div>
<select class="sortbl">
    <option value="">
        <?=\Yii::t('app', 'Сортировка')?></option>
    <option value="1"><?=\Yii::t('app', 'Сортировка')?> <?=\Yii::t('app', 'по увеличению цены')?></option>
    <option value="2"><?=\Yii::t('app', 'Сортировка')?> <?=\Yii::t('app', 'по убыванию цены')?></option>
</select>
<div class="clearfix"></div>
<div class="somelinecontent"></div>

<?php Pjax::begin(['id' => 'catalogPjax']); ?>
<?=$this->render('../category/catalog-list-view',['dataProvider'=>$dataProvider])?>
<?php Pjax::end(); ?>
<!-- -->


</div>
