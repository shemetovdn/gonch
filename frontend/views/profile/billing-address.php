<?php
    use frontend\assets\AppAsset;

    $uniq_state_id=uniqid('state_');
    $uniq_form_id=uniqid('form_');

    $bundle=AppAsset::register($this);

    $this->registerJs('
        $(\'.select2\').select2();
    ',\yii\web\View::POS_END);

?>

<div class="loginpadding newmyacc">
    <div class="log bill">BILLING ADDRESS</div>
    <div class="clearfix"></div>
    <div class="redline"></div>
    <?
        $form=\yii\bootstrap\ActiveForm::begin([
            'layout' => 'horizontal',
            'action' => ['/profile/save-address'],
            'id'=>$uniq_form_id,
            'fieldConfig' => [
                'horizontalCssClasses' => [
                    'offset' => '',
                    'wrapper' => 'col-sm-12',
                ],
            ]
        ]);
    ?>
        <div class="categorieschangeacc">Your billing address is:</div>
        <button class="sign" type="submit">UPDATE</button>
        <div class="clearfix"></div>
        <div class="col-sm-8 leftnonpadding">
                <?=$form->field($formModel,'address',[
                    'options'=>[
                        'class'=>'form-group'
                    ]
                ])->textInput(['placeholder'=>'ADDRESS'])->label(false)?>
                <?=$form->field($formModel,'address1',[
                    'options'=>[
                        'class'=>'form-group'
                    ]
                ])->textInput(['placeholder'=>'APT/SUITE #'])->label(false)?>
                <?=$form->field($formModel,'country_id',[
                    'options'=>[
                        'class'=>'form-group castomselect2'
                    ],
                ])->dropDownList(['COUNTRY'],['class'=>'country select2','data'=>['selected'=>$formModel->country_id,'state'=>'#'.$uniq_state_id], 'style'=>"width: 100%;"])
                    ->label(false)?>
                <?=$form->field($formModel,'state_id',[
                    'options'=>[
                        'class'=>'form-group castomselect2'
                    ],
                ])->dropDownList(['STATE'],['data'=>['selected'=>$formModel->state_id],'id'=>$uniq_state_id,'class'=>'select2', 'style'=>"width: 100%;"])
                    ->label(false)?>
                <?=$form->field($formModel,'city',[
                    'options'=>[
                        'class'=>'form-group'
                    ],
                ])->textInput(['placeholder'=>'CITY'])
                    ->label(false)?>
                <?=$form->field($formModel,'zip',[
                    'options'=>[
                        'class'=>'form-group newpa pull-left'
                    ],
                ])->textInput(['placeholder'=>'ZIP/POSTAL CODE'])
                    ->label(false)?>
        </div>
        <div class="clearfix"></div>
        <?
            yii\bootstrap\ActiveForm::end();
        ?>
</div>


<?

$this->registerJs('
        var countriesJson;
        $.ajax({url:\''.$bundle->baseUrl.'/js/countries.json\',dataType:\'json\',success:function(json){
            countriesJson=json;
            countriesJson.sort(compare);
            $(\'[name="Addresses[country_id]"]\').each(function(){
                for(var i in countriesJson){
                    if (countriesJson[i].code != "") {
                        var selected="";
                        if($(this).data("selected")==countriesJson[i].id) selected="selected";
                        $(this).append(\'<option \'+selected+\' value="\'+countriesJson[i].id+\'">\'+countriesJson[i].title+\'</option>\')
                    }
                }
                $(this).change();
                $(this).trigger("selectFxUpdate");
            });
            
            
        }});

        $(\'[name="Addresses[country_id]"]\').change(function(){
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
                state.trigger("selectFxUpdate");
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

