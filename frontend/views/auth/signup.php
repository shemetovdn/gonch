<?php
    use frontend\widgets\Tabs;
    use yii\widgets\ActiveForm;
$uniq_state_id=uniqid('state_');
$uniq_form_id=uniqid('form_');
    $bundle=\backend\assets\AppAsset::register($this);?>
<section>
    <div class="bg-premium bg-sign bg-signup">
        <div class="container">
            <h1>Sign Up</h1>
            <div class="tsig">Please fill up the form below</div>

   <?php  $form=ActiveForm::begin([
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'id' => 'form',
       'options' => [
           'class' => 'form-horizontal'
       ]

    ]);
    $this->registerJs('
            $("#form").on("beforeSubmit",function(e){
                if($("[name=scenario]").val()=="step1"){
                    $("[name=scenario]").val("step2")
                    $("[href=\'#billing-address\']").tab(\'show\');
                    return false;
                }else if($("[name=scenario]").val()=="step2"){
                    $("[name=scenario]").val("step3")
                    $("[href=\'#credit-cards\']").tab(\'show\');
                    return false;
                }
    
            });
            
            $("[data-toggle=\'tab\']").each(function(){
                $(this).click(function(){
                    return false;
                });
            });
        ', \yii\web\View::POS_END);
?>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Username</label>
                <div class="col-sm-5">
                    <?=$form->field($registerForm,'username')->textInput()->label(false)?>

                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail4" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-5">
                    <?=$form->field($registerForm,'email')->textInput()->label(false)?>

                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-5">
                    <?=$form->field($registerForm,'password')->passwordInput()->label(false)?>

                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail6" class="col-sm-2 control-label">Retype Pass</label>
                <div class="col-sm-5">
                    <?=$form->field($registerForm,'password_confirmation')->passwordInput()->label(false)?>

                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail7" class="col-sm-2 control-label">City</label>
                <div class="col-sm-5">
                    <?=$form->field($registerForm,'user_city')->textInput()->label(false)?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail5" class="col-sm-2 control-label">Code</label>
                <div class="col-sm-5">
                    <?=$form->field($registerForm,'code')->textInput()->label(false)?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-10">
                    <button type="submit" class="btn">Submit</button>
                </div>
            </div>


<div class="modal fade modal-thank-you" id="terms" tabindex="-1" role="dialog" aria-labelledby="LoginLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a type="button" class="close" data-dismiss="modal" aria-hidden="true">×</a>
            </div>
            <div class="modal-body" style="padding-left: 15px;padding-right: 15px;">
                <div class="tex-1">Terms & Conditions</div>
                <div class="tex-2" style="color: #fff;">
                    <?=\backend\modules\pages\models\Pages::findByHref('terms-and-conditions')->one()->contents[0]?>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn-1 btn-2" onclick='$("#terms").modal("hide");return false;'>Close</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
            <? ActiveForm::end(); ?>
        </div>
    </div>
</section>
