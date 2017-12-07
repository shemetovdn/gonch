<?php
use frontend\assets\ImageAsset;
$bundle = ImageAsset::register($this);
$this->registerCssFile($bundle->baseUrl.'/css/bootstrap-chosen.css');
$this->registerJsFile($bundle->baseUrl.'/js/chosen.jquery.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs('

        $(\'.chosen-select\').chosen();
$("#category-parent_id").change(function(){
var id = $(this).val();
    $.ajax({
        url:"default/set-depth",
        type:"POST",
        data:"id="+id,
        success: function(data){
            console.log(data);
            $("#category-depth").val(data);
        }
    
    });

});
        $( "#parametrs" ).sortable();
    $( "#parametrs" ).disableSelection();   
     
     $("#category-params").change(function(){
            var id = $(this).val();
            var title = $(this).find("option:selected").text();
            var html = `<li class="col-md-3"><input type="hidden" name="Category[params_ids][]" value="`+id+`">`+title+` <span class="close">x</span></li>`;
            
            console.log($(`#parametrs li input[value="`+id+`"]`).length == 0);
            if($(`#parametrs li input[value="`+id+`"]`).length == 0){
            $("#parametrs").append(html);
            }
                     
     });
     
     $(document).on("click", "#parametrs li .close",function(){
        $(this).parents("li").remove();
     })  
'
    , yii\web\View::POS_END);
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
<style>
    #parametrs li{
        border: dashed 1px;
        padding: 10px 10px 10px 5px;
        list-style: none;
        display: inline-block;
        margin: 5px;
        cursor: move;
        position: relative;
        text-align: center;
    }
    #parametrs li .close{
        position: absolute;
        right: 2px;
        top: -4px;
    }
</style>
<div class="panel-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="margin-bottom-50">
                <h4>Информация</h4>
                <br />

                <?=$form->field($formModel, 'id')->hiddenInput()->label(false)?>


                <?=$form
                    ->field($formModel,'title',['options'=>['class'=>'form-group row']])
                    ->textInput(['placeholder'=>'Введите заголовок...'])->label("Заголовок ru")
                ?>
                <?=$form
                    ->field($formModel,'title_ua',['options'=>['class'=>'form-group row']])
                    ->textInput(['placeholder'=>'Введите заголовок...'])->label("Заголовок ua")
                ?>
                <?=$form
                    ->field($formModel,'href',['options'=>['class'=>'form-group row']])
                    ->textInput(['placeholder'=>'Ссылка','readonly' => true])->label("Ссылка")
                ?>

                <div class=" form-group row">
                <?= $form
                    ->field($formModel, 'parent_id', [
                        'options' => [
                        ]
                    ])
                    ->dropDownList(
                        \yii\helpers\ArrayHelper::merge(
                            [0 => 'Корневая'],
                            \backend\modules\categories\models\Category::getList('id', 'title', 'id desc')),
                        ['class' => 'chosen-select']
                    )
                    ->label("Родительская Категория");
                ?>

                <?= $form
                    ->field($formModel, 'depth', ['options' => ['style' => 'display:none;']])
                    ->hiddenInput()->label(false)
                ?>
                </div>

                <div class="form-group row">
                    <?= $form
                        ->field($formModel, 'params',['options'=>['class'=>'']])
                        ->dropDownList(
                            \yii\helpers\ArrayHelper::merge(
                                [0 => 'Параметры'],
                                \backend\modules\parametrs\models\Parametrs::getList('id', 'title', 'id desc')),
                            [
                                'class' => 'chosen-select'
                            ]
                        )
                        ->label("Параметры");
                    ?>
                </div>

                <div class="form-group row">
                    <div class="col-md-3"></div>

                    <ul id="parametrs" class="col-md-9">
<?php foreach($formModel->categoryParametrs as $key=>$value){?>
    <li class="col-md-3">
        <input type="hidden" name="Category[params_ids][]" value="<?=$value->parametr_id?>"><?=$value->parametr->title?><span class="close">x</span>
    </li>
    <?}?>
                    </ul>
                </div>

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
                <div class="form-actions">
                    <div class="form-group row">
                        <div class="col-md-9 col-md-offset-3">
                            <?=\yii\helpers\Html::submitButton('Сохранить',['class'=>'btn width-150 btn-primary'])?>
                            <?=\yii\helpers\Html::resetButton('Отмена',['class'=>'btn btn-default'])?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?=$form
                        ->field($formModel,'subtitle',['options'=>['class'=>'form-group row']])
                        ->textInput(['placeholder'=>'Введите Подзаголовок...'])->label("Подзаголовок ru")
                    ?>
                    <?=$form
                        ->field($formModel,'subtitle_ua',['options'=>['class'=>'form-group row']])
                        ->textInput(['placeholder'=>'Введите Подзаголовок...'])->label("Подзаголовок ua")
                    ?>
                    <?=$form
                        ->field($formModel,'description',['horizontalCssClasses' => [
                            'wrapper' => 'col-xs-12','offset'=>''
                        ]])
                        ->widget(\mihaildev\ckeditor\CKEditor::className(), [
                            'editorOptions' => \mihaildev\elfinder\ElFinder::ckeditorOptions('elfinder',\yii\helpers\ArrayHelper::merge(Yii::$app->params['ckeditor'],['height'=>'200'])),
                        ])->label("Описание ru");
                    ?>

                </div>
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
                <div class="form-actions">
                    <div class="form-group row">
                        <div class="col-md-9 col-md-offset-3">
                            <?=\yii\helpers\Html::submitButton('Сохранить',['class'=>'btn width-150 btn-primary'])?>
                            <?=\yii\helpers\Html::resetButton('Отмена',['class'=>'btn btn-default'])?>
                        </div>
                    </div>
                </div>


                <h4>Изображение</h4>
                <br />

                <?php
                    echo \wbp\imageUploader\ImageUploader::widget([
                        'style' => 'estoreMultiple',
                        'data' => [
                            'size'=>'123x123',
                        ],
                        'type' => \backend\modules\categories\models\Category::$imageTypes[0],
                        'item_id' => $formModel->id,
                        'limit' => 1
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

            </div>
        </div>
    </div>
</div>
<? \yii\bootstrap\ActiveForm::end(); ?>