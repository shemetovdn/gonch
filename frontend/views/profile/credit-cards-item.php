<?php
    use yii\widgets\ActiveForm;

    $bundle=\frontend\assets\AppAsset::register($this);

    $uniq_form_id=uniqid('form_');

    $this->registerJs('
        $(\'.select2\').select2();
    ',\yii\web\View::POS_END);


    if(Yii::$app->request->isAjax) echo "<script>$('.select2').select2();</script>";

?>

    <!-- -->

    <div class="collapse <? if($model->number) echo "in"; ?> card-<?=$key?>" style="padding-top: 25px; padding-bottom: 25px;" >

        <div class="cnameblue" style="line-height:35px;font-size: 16px;color: #5b5b5b;font-family: 'MetropolisRegular';">CARD <?=$index+1?><?if($model->type_id) echo ' - '.$model->type->title?></div>
        <div class="block-cardform master-icon" style="line-height:30px;font-size: 16px;color: #5b5b5b;font-family: 'MetropolisRegular';">
            <?=$model->cardholder_name?$model->cardholder_name:'Cardholder name'?><br>
            <?if($model->type_id) echo $model->type->title?><br>
            xxxx  xxxx  xxxxx <?=$model->number?mb_substr($model->number,-4,4):'xxxx'?>
        </div>
        <div class="rightformcl" style="margin-top: 30px;padding-bottom: 30px;">
            <a href="#" data-id="<?=$model->id?>" class="sign delete-card-<?=$uniq_form_id?>">DELETE</a>
            <a class="sign addcard" data-toggle="collapse" data-target=".card-<?=$key?>" style="margin-right: 30px;">update</a>
            <div class="clearfix"></div>
        </div>


    </div>

    <div class="collapse <? if(!$model->number) echo "in"; ?> card-<?=$key?>" >

        <? if(!$model->number){ ?>
            <div class="categorieschangeacc">ADD NEW CARD</div>
        <? }else{ ?>
            <div class="categorieschangeacc">EDIT CARD</div>
        <? } ?>

        <? $form=ActiveForm::begin([
            'id'=>$uniq_form_id,
            'action' => ['/profile/save-card'],
        ]); ?>

        <?=$form->field($model,'id',['options'=>['style'=>'display:none;']])->hiddenInput()->label(false)?>

        <div class="clearfix"></div>
        <div class="col-sm-8 leftnonpadding">
            <?=$form->field($model,'cardholder_name')->textInput(['placeholder'=>"CARDHOLDER NAME"])->label(false)?>
            <?=$form->field($model,'type_id',['options'=>['class'=>'form-group castomselect2']])->dropDownList(\yii\helpers\ArrayHelper::merge(['CARD TYPE'],\common\models\CardTypes::getList('id','title','id')),['class'=>'select2', 'style'=>"width: 100%;"])->label(false)?>
            <?=$form->field($model,'number')->textInput(['placeholder'=>"CARD NUMBER"])->label(false)?>
            <div class="row">
                <div class="col-sm-6">
                    <?=$form->field($model,'expired_month',['template' => "{input}\n{hint}\n{error}",'options'=>['class'=>'form-group castomselect2']])->dropDownList(\common\models\CardTypes::getMonthes(),['class'=>'select2', 'style'=>"width: 100%;"])->label(false)?>
                </div>
                <div class="col-sm-6">
                    <?=$form->field($model,'expired_year',['template' => "{input}\n{hint}\n{error}",'options'=>['class'=>'form-group castomselect2']])->dropDownList(\common\models\CardTypes::getYears(),['class'=>'select2', 'style'=>"width: 100%;"])->label(false)?>
                </div>
            </div>
            <?=$form->field($model,'cvv')->passwordInput(['placeholder'=>"CVV CODE"])->label(false)?>
            <?=$form->field($model,'agree')->checkbox(['id'=>$uniq_form_id.'_agree','label'=>'I agree to all <a href="#" onclick="$(\'#terms\').modal(\'show\');return false;" class="terms">terms and conditions</a>','labelOptions'=>['class'=>'control control--checkbox']])->label(false)?>
        </div>
        <div class="clearfix"></div>
        <div class="text-center">
            <button type="submit" class="btn btn-default">SAVE</button>
        </div>
    <? ActiveForm::end(); ?>
    <div class="clearfix"></div>
    <div class="linemyacc"></div>
</div>




    <div class="modal fade modal-thank-you" id="delete-card-<?=$uniq_form_id?>" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a type="button" class="close" data-dismiss="modal" aria-hidden="true">×</a>
                <div class="modal-header artcustmodal">
                    <div class="bootstrap-dialog-header">
                        <div class="bootstrap-dialog-title"></div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="tex-1">Are you sure want to delete this card?</div>
                </div>
                <div class="modal-footer">
                    <a href="<?=\yii\helpers\Url::to(['/profile/remove-card', 'id'=>$model->id])?>" class="btn-1 shura">YES, I’M SURE</a>
                    <div class="or">OR</div>
                    <a href="#" class="btn-1 btn-2" onclick="$('#delete-card-<?=$uniq_form_id?>').modal('hide');return false;">NO, CANCEL</a>
                </div>
            </div>
        </div>
    </div>


<?php

$this->registerJs('
        $("#'.$uniq_form_id.'").on("beforeSubmit", function (event, messages, errorAttributes) {
            var data=$(this).serialize();
            showAjaxerMask();
            $.ajax({
                url:$(this).attr("action"),
                data: data,
                method: "POST",
                success:function(data){
                    $("body").append(data);
                    $.pjax.reload("#cardsNew", {timeout: 10000});
                }
            });
        });
        $("#'.$uniq_form_id.'").submit(function(){
            return false;
        });
    ');

$this->registerJs('
        $(".delete-card-'.$uniq_form_id.'[data-id]").click(function(){
            $(\'#delete-card-'.$uniq_form_id.'\').modal(\'show\');
            return false;
        });
        
         $(\'#delete-card-'.$uniq_form_id.' .shura\').click(function(){
              $.post("/profile/remove-card",{"id":"'.$model->id.'"},function(data){
                   $.pjax.reload("#cardsNew", {timeout: 10000});
                })
            $(\'#delete-card-'.$uniq_form_id.'\').modal(\'hide\');
            return false;
        });
       

    ');