<?php


?>

<div class="loginpadding newmyacc">
    <div class="log myacc">SIGN UP</div>
    <div class="clearfix"></div>
    <div class="redline"></div>
    <div class="col-sm-8 col-sm-offset-2 text-center">
        <?=$form->field($registerForm,'username')->textInput(["placeholder"=>"USERNAME"])->label(false)?>
        <?=$form->field($registerForm,'email')->textInput(["placeholder"=>"EMAIL ADDRESS"])->label(false)?>
        <?=$form->field($registerForm,'password')->passwordInput(["placeholder"=>"PASSWORD"])->label(false)?>
        <?=$form->field($registerForm,'password_confirmation')->passwordInput(["placeholder"=>"RE-ENTER PASSWORD"])->label(false)?>
        <button class="btn-default" type="submit">NEXT STEP</button>
    </div>
    <div class="clearfix"></div>
</div>
