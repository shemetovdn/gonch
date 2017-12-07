<?
    use frontend\assets\AppAsset;

    $uniq_state_id=uniqid('state_');
    $uniq_form_id=uniqid('form_');

    $bundle=AppAsset::register($this);

    $form=\yii\bootstrap\ActiveForm::begin([
        'layout' => 'horizontal',
        'action' => ['/dashboard-profile/save-address'],
        'id'=>$uniq_form_id,
    ]);

    echo \yii\helpers\Html::beginTag('div',['class'=>'address_form address_'.$formModel->type]);
?>
        <div class="clearfix"></div>
        <div class="namemyacc" style="float: left;"><? if($formModel->type==1) echo 'SHIPPING ADDRESS'; else echo 'BILLING ADDRESS';?></div>
        <a href="#" class="update">EDIT</a>
            <?
                if($formModel->type==1) {
            ?>
                <div class="checkbox editor" style="float: left;margin-left: 25px;margin-top: 15px;display: none;">
                    <?= \yii\bootstrap\Html::checkbox('same_as', false, ['id' => $uniq_form_id . '_same_as', 'data'=>['form'=>'address_0'],'class' => '', 'label' => 'Same as billing address']) ?>
                </div>
                <div class="clearfix"></div>

                <?php

                $this->registerJs('
                        $("#'.$uniq_form_id.'_same_as").change(function(){
                            if($(this).prop("checked")){
                                var copyFrom=$("."+$(this).data("form"));
                                $(this).parents(".address_form").find("input[type=text]").each(function(){
                                    $(this).val(copyFrom.find("[name=\'"+$(this).attr("name")+"\']").val());
                                })
                                $(this).parents(".address_form").find("select").each(function(){
                                    var th=$(this);
                                    setTimeout(function(){ 
                                        th.val(copyFrom.find("[name=\'"+th.attr("name")+"\']").val()); 
                                        th.change();
                                    }, 50);
                                })
                            }
                        });
            //            $("#'.$uniq_form_id.'_same_as").parents(".address_form").find("input[type=text], select").change(function(){
            //                if($("#'.$uniq_form_id.'_same_as").prop("checked")){
            //                    $("#'.$uniq_form_id.'_same_as").prop("checked", false);
            //                    $("#'.$uniq_form_id.'_same_as").change();
            //                }
            //            })
                    ');

            }
            ?>

        <div class="clearfix"></div>

        <div class="editor" style="display: none;">

                    <?=$form->field($formModel,'type',['options'=>['class'=>'hidden-lg']])->hiddenInput()->label(false)?>

                    <?=$form->field($formModel,'address',[
                        'options'=>[
                            'class'=>'form-group newpa'
                        ],
                        'horizontalCssClasses' => ['wrapper' => 'wid-2 pull-left']
                    ])->textInput()->label('Address',['class'=>'control-label wid-2 pull-left'])?>
                    <?=$form->field($formModel,'address1',[
                        'options'=>[
                            'class'=>'form-group newpa'
                        ],
                        'horizontalCssClasses' => ['wrapper' => 'wid-2 pull-left']
                    ])->textInput()->label('Apt/Suite No.',['class'=>'control-label wid-2 pull-left'])?>
                    <?=$form->field($formModel,'country_id',[
                        'options'=>[
                            'class'=>'form-group newpa'
                        ],
                        'horizontalCssClasses' => ['wrapper' => 'wid-2 pull-left']
                    ])->dropDownList(['select'],['class'=>'form-control country','data'=>['selected'=>$formModel->country_id,'state'=>'#'.$uniq_state_id]])->label('Country',['class'=>'control-label wid-2 pull-left'])?>
                    <?=$form->field($formModel,'state_id',[
                        'options'=>[
                            'class'=>'form-group newpa'
                        ],
                        'horizontalCssClasses' => ['wrapper' => 'wid-2 pull-left']
                    ])->dropDownList(['select'],['data'=>['selected'=>$formModel->state_id],'id'=>$uniq_state_id])->label('State',['class'=>'control-label wid-2 pull-left'])?>
                    <?=$form->field($formModel,'city',[
                        'options'=>[
                            'class'=>'form-group newpa'
                        ],
                        'horizontalCssClasses' => ['wrapper' => 'wid-2 pull-left']
                    ])->textInput()->label('City',['class'=>'control-label wid-2 pull-left'])?>
                    <?=$form->field($formModel,'zip',[
                            'options'=>[
                                    'class'=>'form-group newpa pull-left'
                            ],
                            'horizontalCssClasses' => ['wrapper' => 'wid-2 pull-left']
                    ])->textInput()->label('ZIP/POSTAL CODE',['class'=>'control-label wid-2 pull-left'])?>

                <div class="pull-right">
                    <button type="submit" class="btn btn-default">SAVE</button>
                </div>

        </div>
        <div class="clearfix"></div>
        <div class="linemyacc" style="margin-top: 0;"></div>
<?
    echo \yii\helpers\Html::endTag('div');
    \yii\bootstrap\ActiveForm::end();
?>


<?

    $this->registerJs('
        var countriesJson;
        $.ajax({url:\''.$bundle->baseUrl.'/js/countries.json\',dataType:\'json\',success:function(json){
            countriesJson=json;
            countriesJson.sort(compare);
            $(\'.country\').each(function(){
                for(var i in countriesJson){
                    if (countriesJson[i].code != "") {
                        var selected="";
                        if($(this).data("selected")==countriesJson[i].id) selected="selected";
                        $(this).append(\'<option \'+selected+\' value="\'+countriesJson[i].id+\'">\'+countriesJson[i].title+\'</option>\')
                    }
                }
                $(this).change();
            });
            
            
        }});

        $(\'.country\').change(function(){
            var currentCountry;
            for(var i in countriesJson){
            if(countriesJson[i].id==$(this).val())
                    currentCountry=countriesJson[i];
            }
            
            var state=$($(this).data("state"));
            
            state.find(\'option\').not(state.find(\'option\').eq(0)).remove();
            if(currentCountry){
                for(i in currentCountry.regions){
                    var selected="";
                    if(state.data("selected")==currentCountry.regions[i].id){ 
                        selected="selected";
                        state.data("selected","");
                    }
                    state.append(\'<option \'+selected+\' value="\'+currentCountry.regions[i].id+\'">\'+currentCountry.regions[i].title+\'</option>\')
                }
            }
        })

        function compare(a,b) {
              if (a.sort < b.sort)
                return -1;
              else if (a.sort > b.sort)
                return 1;
              else if(a.title > b.title)
                return 1;
              else if(a.title < b.title)
                return -1;
              else
                return 0;
        }
    ', \yii\web\View::POS_END, 'countries_json');

    $this->registerJs('
        $("#'.$uniq_form_id.'").on("beforeSubmit", function (event, messages, errorAttributes) {
//            if(!errorAttributes.length){
                var data=$(this).serialize();
                var form=$(this);
                $.ajax({
                    url:$(this).attr("action"),
                    data: data,
                    method: "POST",
                    success:function(data){
                        $("body").append(data);
                        form.find(".editor").hide();
                        form.find(".update").show();
                    }
                });
//            }
        });
        $("#'.$uniq_form_id.'").submit(function(){
            return false;
        });
    ', \yii\web\View::POS_END);

?>
