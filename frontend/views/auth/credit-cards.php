<?php
    $uniq_form_id=uniqid('form_');
?>

<div class="loginpadding newmyacc">
    <div class="log cards">PAYMENT</div>
    <div class="clearfix"></div>
    <div class="redline"></div>
        <div class="categorieschangeacc">Add payment info:</div>
        <div class="clearfix"></div>
        <div class="col-sm-8 leftnonpadding">
            <?=$form->field($registerForm,'cardholder_name')->textInput(['placeholder'=>"CARDHOLDER NAME"])->label(false)?>
            <?=$form->field($registerForm,'type_id',['options'=>['class'=>'form-group castomselect2']])->dropDownList(\yii\helpers\ArrayHelper::merge(['CARD TYPE'],\common\models\CardTypes::getList('id','title','id')),['class'=>'select2', 'style'=>"width: 100%;"])->label(false)?>
            <?=$form->field($registerForm,'number')->textInput(['placeholder'=>"CARD NUMBER"])->label(false)?>
            <div class="row">
                <div class="col-sm-6">
                    <?=$form->field($registerForm,'expired_month',['template' => "{input}\n{hint}\n{error}",'options'=>['class'=>'form-group castomselect2']])->dropDownList(\common\models\CardTypes::getMonthes(),['class'=>'select2', 'style'=>"width: 100%;"])->label(false)?>
                </div>
                <div class="col-sm-6">
                    <?=$form->field($registerForm,'expired_year',['template' => "{input}\n{hint}\n{error}",'options'=>['class'=>'form-group castomselect2']])->dropDownList(\common\models\CardTypes::getYears(),['class'=>'select2', 'style'=>"width: 100%;"])->label(false)?>
                </div>
            </div>
            <?=$form->field($registerForm,'cvv')->passwordInput(['placeholder'=>"CVV CODE"])->label(false)?>
            <?=$form->field($registerForm,'agree')->checkbox(['id'=>$uniq_form_id.'_agree','label'=>'I agree to all <a href="#" onclick="$(\'#terms\').modal(\'show\');return false;" class="terms">terms and conditions</a>','labelOptions'=>['class'=>'control control--checkbox']])->label(false)?>
        </div>
        <div class="clearfix"></div>
        <div class="text-center">
            <button type="submit" class="btn btn-default">SUBMIT</button>
        </div>
</div>
