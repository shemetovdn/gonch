<?php
    \wbp\ajaxer\AjaxerAsset::register($this);
?>

<div class="loginpadding newmyacc">
    <div class="log myacc">MY ACCOUNT</div>
    <div class="clearfix"></div>
    <div class="redline"></div>
    <div class="categorieschangeacc">Your email address is: </div>
    <a class="sign email-edit" data-toggle="collapse" data-target=".email-update-form" onclick="$(this).hide();">EDIT</a>
    <div class="clearfix"></div>
    <div class="redtextacc collapse in email-update-form" id="current-email-address"><?=Yii::$app->user->identity->email?></div>
<!--    <div class="redtextacc">jas.mathur@emblazeone.com</div>-->
    <div class="collapse email-update-form" id="email-update-form">
        <?=$this->render('my-account-email-form',['formModel'=>$emailUpdate])?>
    </div>

    <div class="linesilveracc"></div>
    <div class="categorieschangeacc">Change Your Name</div>
    <a class="sign fname-edit" data-toggle="collapse" data-target=".fname-update-form" onclick="$(this).hide();">EDIT</a>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-sm-12">
                <div class="blacktextacc col-sm-5">FIRST NAME</div>
                <div class="blacktextacc col-sm-5">LAST NAME</div>
                <div class="col-sm-12 fname-update-form collapse in">
                    <div class="row">
                        <div class="redtextacc col-sm-5" id="current-fname"><?=Yii::$app->user->identity->first_name?></div>
                        <div class="redtextacc col-sm-5" id="current-lname"><?=Yii::$app->user->identity->last_name?></div>
                    </div>
                </div>
                <div class="fname-update-form collapse">
                    <?=$this->render('my-account-fname-lname-form',['formModel'=>$fnameUpdate])?>
                </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="linesilveracc"></div>
    <div class="categorieschangeacc">Change Your Username</div>
    <a class="sign username-edit" data-toggle="collapse" data-target=".username-update-form" onclick="$(this).hide();">EDIT</a>
    <div class="clearfix"></div>
    <div class="col-sm-12">
        <div class="blacktextacc">USERNAME</div>
        <div class="redtextacc username-update-form in" id="current-username"><?=Yii::$app->user->identity->username?></div>
        <div class="username-update-form collapse">
            <?=$this->render('my-account-username-form',['formModel'=>$usernameUpdate])?>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="linesilveracc"></div>
    <div class="categorieschangeacc">Change Your Password</div>
    <a class="sign password-edit" data-toggle="collapse" data-target=".password-update-form" onclick="$(this).hide();">EDIT</a>
    <div class="clearfix"></div>
    <div class="password-update-form collapse">
        <?=$this->render('my-account-password-form',['formModel'=>$passwordUpdate])?>
    </div>
    <div class="clearfix"></div>
    <div class="linesilveracc"></div>
</div>
