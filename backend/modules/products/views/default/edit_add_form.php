<?
use backend\modules\products\models\Products;
use common\models\User;
use yii\widgets\Pjax;
use frontend\assets\ImageAsset;
$bundle = ImageAsset::register($this);
$this->registerCssFile($bundle->baseUrl.'/css/bootstrap-chosen.css');
$this->registerJsFile($bundle->baseUrl.'/js/chosen.jquery.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs('
        $(\'.chosen-select\').chosen();
        $(\'.chosen-select-deselect\').chosen({ allow_single_deselect: true });
$("#products-category_id").change(function(){

    var url_to = "'.\yii\helpers\Url::to().'";
    var category_id = $(this).val();
    $.pjax.reload({url: url_to,"container":"#parametrs", history:true,type: "POST", data: "category_id="+category_id, timeout: 10000}).done(function() {

    });
});

$("#products-associated_id").change(function(){

    var id = $(this).val();
    $.ajax({
    url:"/admin/products/get-product",
    type:"POST",
    data:"id="+id,
    success: function(data){
    data = JSON.parse(data);
    
    var html = `
     <tr ><td class="center">`+data.id+`</td>
     <td><img src="`+data.image+`" style="    width: 40px;"></td>
        <td>`+data.title+`</td>
        <td>`+data.category_title+`</td>
        <td class="center">
            <div class="btn-group btn-actions" aria-label="" role="group" style="">
                <a  class="btn btn-danger remove_assoc" href="#" data-pjax="0" data-id="`+data.id+`" data-ajax="0"><i class="icmn-bin" aria-hidden="true"></i></a>    </div>
        <input type="hidden" value="`+data.id+`" name="Products[associated][]">
        </td>
    </tr>   
    `;
$("#asssociated > tbody").append(html);

        $("#products-associated_id").val(1).trigger("chosen:updated");
        $(".field-products-associated_id a.chosen-single > span").text("Выберите товар");



    }
    })
});
$(document).on("click", ".remove_assoc", function(event){
        event.preventDefault();
        var id = $(this).attr("data-id");
        var ajax = $(this).attr("data-ajax");
        var parent = $(this).parents("tr");
        
        if(ajax == 1){
    $.ajax({
    url:"/admin/products/delete-associated",
    type:"POST",
    data:"id="+id,
    success: function(data){
    
        $(parent).remove();
    }
    })
        }else{
                $(parent).remove();
        }

        
})

//    $( "#sortable" ).sortable();
//    $( "#sortable" ).disableSelection();

', yii\web\View::POS_READY);
?>


<? $form=\yii\bootstrap\ActiveForm::begin([
    'layout' => 'horizontal',
    'fieldConfig' => [
        'template' => "<div class=\"col-md-3\">\n{label}\n</div>\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
        'horizontalCssClasses' => [
            'label' => 'form-control-label',
            'offset' => 'col-sm-offset-4',
            'wrapper' => 'col-md-9',
            'error' => '',
            'hint' => '',
        ],
    ],
]); ?>
<?php
//    if($formModel->user_id){
//        $user_id = $formModel->user_id;
//        $user = $formModel->user;
//    }else{
//        $user_id = Yii::$app->user->id;
//        $user = \common\models\User::findOne(Yii::$app->user->id);
//    }
//?>
<!---->
<?//= $form
//    ->field($formModel, 'user_id', [
//        'options' => [
//        ]
//    ])
//    ->hiddenInput(['value' => $user_id])->label(false);
//?>
<style>

/*    #sortable div.sortable_item{
        border: solid 1px #eee;
        padding: 3px 0;
        cursor: move;
    }*/

</style>

<div class="panel-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="margin-bottom-50">
                <h4>Категория</h4>
                        <div class="row">
                            <?= $form
                                ->field($formModel, 'category_id',['options'=>['class'=>'col-md-12']])
                                ->dropDownList(
                                    \yii\helpers\ArrayHelper::merge(
                                        [0 => 'Категория товара'],
                                        \backend\modules\categories\models\Category::getList('id', 'title', 'id desc')),
                                    [
                                         'class' => 'chosen-select'
                            ]
                                )
                                ->label(false);
                            ?>
                        </div>
                <h4>Статус</h4>
                <div class="row">
                    <div class="col-md-3">Активна / Деактивирована</div>
                    <div class="col-md-9">
                        <?= $form
                            ->field($formModel, 'status', ['options' => ['style' => 'display:none;']])
                            ->hiddenInput(['value' => 0])->label(false)
                        ?>
                        <?= $form
                            ->field($formModel, 'status',['template' => "{input}\n{hint}\n{error}",'horizontalCssClasses' => [
                                'wrapper' => 'top-minus','offset'=>''
                            ]])->checkbox()->label("");
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">Наличие</div>
                    <div class="col-md-9">
                        <?= $form
                            ->field($formModel, 'availability', ['options' => ['style' => 'display:none;']])
                            ->hiddenInput(['value' => 0])->label(false)
                        ?>
                        <?= $form
                            ->field($formModel, 'availability',['template' => "{input}\n{hint}\n{error}",'horizontalCssClasses' => [
                                'wrapper' => 'top-minus','offset'=>''
                            ]])->checkbox()->label("");
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">Рекомендуемые</div>
                    <div class="col-md-9">
                        <?= $form
                            ->field($formModel, 'recommended', ['options' => ['style' => 'display:none;']])
                            ->hiddenInput(['value' => 0])->label(false)
                        ?>
                        <?= $form
                            ->field($formModel, 'recommended',['template' => "{input}\n{hint}\n{error}",'horizontalCssClasses' => [
                                'wrapper' => 'top-minus','offset'=>''
                            ]])->checkbox()->label("");
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">Рекомендуемые на главной</div>
                    <div class="col-md-9">
                        <?= $form
                            ->field($formModel, 'recommended_home', ['options' => ['style' => 'display:none;']])
                            ->hiddenInput(['value' => 0])->label(false)
                        ?>
                        <?= $form
                            ->field($formModel, 'recommended_home',['template' => "{input}\n{hint}\n{error}",'horizontalCssClasses' => [
                                'wrapper' => 'top-minus','offset'=>''
                            ]])->checkbox()->label("");
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">Распродажа</div>
                    <div class="col-md-9">
                        <?= $form
                            ->field($formModel, 'sale', ['options' => ['style' => 'display:none;']])
                            ->hiddenInput(['value' => 0])->label(false)
                        ?>
                        <?= $form
                            ->field($formModel, 'sale',['template' => "{input}\n{hint}\n{error}",'horizontalCssClasses' => [
                                'wrapper' => 'top-minus','offset'=>''
                            ]])->checkbox()->label("");
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">Слайдер на главной</div>
                    <div class="col-md-9">
                        <?= $form
                            ->field($formModel, 'in_home', ['options' => ['style' => 'display:none;']])
                            ->hiddenInput(['value' => 0])->label(false)
                        ?>
                        <?= $form
                            ->field($formModel, 'in_home',['template' => "{input}\n{hint}\n{error}",'horizontalCssClasses' => [
                                'wrapper' => 'top-minus','offset'=>''
                            ]])->checkbox()->label("");
                        ?>
                    </div>
                </div>


                <div class="form-actions">
                    <div class="form-group row">
                        <div class="col-md-9 col-md-offset-3">
                            <?=\yii\helpers\Html::submitButton('Сохранить',['class'=>'btn width-150 btn-primary'])?>
                            <?=\yii\helpers\Html::resetButton('Отмена',['class'=>'btn btn-default'])?>
                        </div>
                    </div>
                </div>

                <h4>Об объекте</h4>
                <br />

                <?=$form
                    ->field($formModel,'title',['options'=>['class'=>'form-group row']])
                    ->textInput(['placeholder'=>'Введите название...'])->label('Название')
                ?>
                <?=$form
                    ->field($formModel,'title_ua',['options'=>['class'=>'form-group row']])
                    ->textInput(['placeholder'=>'Введите название...'])->label('Название ua')
                ?>
                <?=$form
                    ->field($formModel,'artikul',['options'=>['class'=>'form-group row']])
                    ->textInput(['placeholder'=>'Артикул...'])->label('Артикул')
                ?>
                <?= $form
                    ->field($formModel, 'href',['options'=>['class'=>'form-group row']])
                    ->textInput(['readonly' => true])
                ?>

                <?= $form
                    ->field($formModel, 'price',['options'=>['class'=>'form-group row']])
                    ->textInput()
                ?>
                <?= $form
                    ->field($formModel, 'old_price',['options'=>['class'=>'form-group row']])
                    ->textInput()
                ?>
<!--                --><?//= $form
//                    ->field($formModel, 'discount_id',['options'=>['class'=>'form-group row']])
//                    ->dropDownList(
//                        \yii\helpers\ArrayHelper::merge(
//                            [0 => 'Выберите скидку'],
//                            \backend\modules\discounts\models\Discounts::getList('id', 'title', 'id desc')),
//                        [
//                            'class' => 'chosen-select'
//                        ]
//                    )
//                    ->label("Скидки");
//                ?>

                <div class="form-actions">
                    <div class="form-group row">
                        <div class="col-md-9 col-md-offset-3">
                            <?=\yii\helpers\Html::submitButton('Сохранить',['class'=>'btn width-150 btn-primary'])?>
                            <?=\yii\helpers\Html::resetButton('Отмена',['class'=>'btn btn-default'])?>
                        </div>
                    </div>
                </div>

                <h4>Описание</h4>
                <br />

                <div class="row">
                    <?=$form
                        ->field($formModel,'description',['horizontalCssClasses' => [
                            'wrapper' => 'col-xs-12','offset'=>''
                        ]])
                        ->widget(\mihaildev\ckeditor\CKEditor::className(), [
                            'editorOptions' => \mihaildev\elfinder\ElFinder::ckeditorOptions('elfinder',\yii\helpers\ArrayHelper::merge(Yii::$app->params['ckeditor'],['height'=>'200'])),
                        ])->label("Описание ru");
                    ?>
                </div>

                <div class="clearfix"></div>

                <div class="row">
                    <?=$form
                        ->field($formModel,'description_ua',['horizontalCssClasses' => [
                            'wrapper' => 'col-xs-12','offset'=>''
                        ]])
                        ->widget(\mihaildev\ckeditor\CKEditor::className(), [
                            'editorOptions' => \mihaildev\elfinder\ElFinder::ckeditorOptions('elfinder',\yii\helpers\ArrayHelper::merge(Yii::$app->params['ckeditor'],['height'=>'200'])),
                        ])->label("Описание ua");
                    ?>
                </div>

                <div class="clearfix"></div>
                <div class="form-actions">
                    <div class="form-group row">
                        <div class="col-md-9 col-md-offset-3">
                            <?=\yii\helpers\Html::submitButton('Сохранить',['class'=>'btn width-150 btn-primary'])?>
                            <?=\yii\helpers\Html::resetButton('Отмена',['class'=>'btn btn-default'])?>
                        </div>
                    </div>
                </div>
                <?php
                Pjax::begin(['id' => 'parametrs']);
                 $category = \backend\modules\categories\models\Category::findOne($formModel->category_id);
                ?>
                <?php if(!empty($formModel->cat_fore_params->categoryParametrs)){?>

                <h4>Параметры</h4>


                    <div id="sortable">
                        <?php
                        $count = 0;
                        ?>
                        <?php foreach($formModel->cat_fore_params->categoryParametrs as $key => $value){?>

                            <?php if($value->parametr->field_type_id == 1){?>
                                <div class="form-group row sortable_item">
                                    <div class="col-md-3">
                                        <label class="control-label form-control-label"><?php echo $value->parametr->title?></label>
                                    </div>
                                    <div class="col-md-9 field-products-repairs_id">

                                        <select id="products-<?php echo $value->parametr_id;?>" class="form-control" name="Products[parametrs][<?php echo $value->parametr->field_type_id;?>][<?php echo $value->parametr_id;?>][value]">
                                            <option value="">Вариант не выбран</option>
                                            <?php foreach($value->parametr->parametrValue as $key =>$paramValue){?>

                                                <option value="<?php echo $paramValue["id"]?>" <?php if($formModel->params[$value->parametr_id]['value'] == $paramValue["id"]){ echo "selected='selected'";}?>><?php echo $paramValue["value"]?></option>
                                            <?php }?>
                                        </select>
                                        <input type="hidden" id="products-<?php echo $value->parametr_id;?>" class="form-control" name="Products[parametrs][<?php echo $value->parametr->field_type_id;?>][<?php echo $value->id;?>][sort]" value="<?php echo $count;?>">
                                        <div class="help-block"></div>
                                    </div>
                                </div>
                            <?php }elseif($value->parametr->field_type_id == 2){?>
                                <div class="form-group row  sortable_item">
                                    <div class="col-md-3">
                                        <label class="control-label form-control-label"><?php echo $value->title?></label>
                                    </div>
                                    <div class="col-md-9 field-adverts-<?php echo $value->id;?>">
                                        <div>
                                            <?php foreach($value->parametrValue as $paramKey =>$paramValue){?>
                                                <label><input type="checkbox" name="Products[parametrs][<?php echo $value->field_type_id;?>][<?php echo $value->id;?>][]" <?php if(in_array($paramValue["id"], explode(',', $formModel->params[$value->id]['value']))){ echo "checked='checked'";}?> value="<?php echo $paramValue["id"]?>"> <?php echo $paramValue["value"]?></label>

                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                            <?php }elseif($value->parametr->field_type_id == 3){?>
                                <div class="form-group row  sortable_item">
                                    <div class="col-md-3">
                                        <label class="control-label form-control-label"><?php echo $value->parametr->title?></label>
                                    </div>
                                    <div class="col-md-9 field-products-<?php echo $value->parametr_id;?> parameters_input">
                                        <label>ru
                                            <input type="text" id="products-<?php echo $value->parametr_id;?>" class="form-control" name="Products[parametrs][<?php echo $value->parametr->field_type_id;?>][<?php echo $value->parametr_id;?>][value]" value="<?php echo $formModel->params[$value->parametr_id]['value'];?>">
                                        </label>
                                        <label>ua
                                            <input type="text" id="products-<?php echo $value->parametr_id;?>" class="form-control" name="Products[parametrs][<?php echo $value->parametr->field_type_id;?>][<?php echo $value->parametr_id;?>][value_ua]" value="<?php echo $formModel->params[$value->parametr_id]['value_ua'];?>">
                                        </label>
                                        <input type="hidden" id="products-<?php echo $value->parametr_id;?>" class="form-control" name="Products[parametrs][<?php echo $value->parametr->field_type_id;?>][<?php echo $value->parametr_id;?>][sort]" value="<?php echo $count;?>">

                                    </div>
                                </div>
                            <?php }?>
                        <?php $count++;
                        }?>

                    </div>

                    <div class="form-actions">
                        <div class="form-group row">
                            <div class="col-md-9 col-md-offset-3">
                                <?=\yii\helpers\Html::submitButton('Сохранить',['class'=>'btn width-150 btn-primary'])?>
                                <?=\yii\helpers\Html::resetButton('Отмена',['class'=>'btn btn-default'])?>
                            </div>
                        </div>
                    </div>
                <?php }?>
                <?php Pjax::end(); ?>



                <h4>Фото</h4>
                <br />

                <?php

                    echo \wbp\imageUploader\ImageUploader::widget([
                        'style' => 'estoreMultiple',
                        'data' => [
                            'size' => '123x123',
                        ],
                        'type' => Products::$imageTypes[0],
                        'item_id' => $formModel->id,
                        'limit' => 999
                    ]);

                ?>

                <div class="clearfix"></div>

                <div class="form-actions">
                    <div class="form-group row">
                        <div class="col-md-9 col-md-offset-3">
                            <?=\yii\helpers\Html::submitButton('Сохранить',['class'=>'btn width-150 btn-primary'])?>
                            <?=\yii\helpers\Html::resetButton('Отмена',['class'=>'btn btn-default'])?>
                        </div>
                    </div>
                </div>

                <h4>Сопутствующие товары</h4>
                <div class="row">
                    <?php
                    if(!empty($formModel->id)){
                        $products = \backend\modules\products\models\Products::getList('id', 'title', 'id desc', ['!=', 'id', $formModel->id]);
                    }else{
                        $products = \backend\modules\products\models\Products::getList('id', 'title', 'id desc');
                    }
                    ?>
                    <?= $form
                        ->field($formModel, 'associated_id',['options'=>['class'=>'col-md-12']])
                        ->dropDownList(
                            \yii\helpers\ArrayHelper::merge(
                                [0 => 'Выберите товар'],
                                $products),
                            [
                                'class' => 'chosen-select'
                            ]
                        )
                        ->label(false);
                    ?>
                </div>
                <div class="clearfix"></div>
                    <table id="asssociated" class="table table-hover nowrap js-table-sortable ui-sortable" style="margin-top: 15px">
                        <thead>
                        <tr>

                            <th style="width: 1%;" class="center">ID</th>
                            <th></th>
                            <th>Заголовок</th>
                            <th>Категория</th>
                            <th class="center" style="width: 80px;">Дейcтвия</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php if(!empty($formModel->associated)){?>
<?php foreach($formModel->associated as $key => $product){?>

    <tr><td class="center"><?php echo $product->product->id;?></td>
        <td><img src="<?php echo $product->product->image->getUrl();?>" style="    width: 40px;"></td>
        <td><?php echo $product->product->title;?></td>
        <td><?php echo $product->product->category->title;?></td>
        <td class="center">
            <div class="btn-group btn-actions" aria-label="" role="group" style="">
                <a class="btn btn-danger remove_assoc" href="#" data-pjax="0" data-id="<?php echo $product->id;?>" data-ajax="1"><i class="icmn-bin" aria-hidden="true"></i></a>    </div>
       <input type="hidden" value="<?php echo $product->product->id;?>" name="Products[associated][]">
        </td>
    </tr>

<?php }?>
                        <?php }?>

                        </tbody>

                    </table>
                <div class="form-actions">
                    <div class="form-group row">
                        <div class="col-md-9 col-md-offset-3">
                            <?=\yii\helpers\Html::submitButton('Сохранить',['class'=>'btn width-150 btn-primary'])?>
                            <?=\yii\helpers\Html::resetButton('Отмена',['class'=>'btn btn-default'])?>
                        </div>
                    </div>
                </div>

                </div>


                <? \yii\bootstrap\ActiveForm::end(); ?>
            <style>
                .chosen-container{
                    /*width:100%!important;*/

                }
                .row .col-sm-offset-4{
                    margin-left: 0;
                }

                #parametrs .row .parameters_input label{
                    margin-right:5px;

                }
            </style>

