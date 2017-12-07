<?
use common\models\Promo;


?>

<? $form=\yii\widgets\ActiveForm::begin(); ?>



<div class="widget">
    <div class="widget-head">
        <h4 class="heading glyphicons circle_info"><i></i>Auth information</h4>
    </div>

    <div class="widget-body">

        <div class="row">

            <!-- Column -->
            <div class="col-md-4">
                <strong>Client <?=$formModel->getAttributeLabel('username')?></strong>
                <p class="muted">This name will be used for login to admin panel </p>
            </div>
            <!-- // Column END -->
            <?=$form
                ->field($formModel,'username',[
                    'options'=>[
                        'class'=>'col-md-8'
                    ]
                ])
                ->textInput([
                    'placeholder'=>'Enter user name here...'
                ])
            ?>

        </div>

        <hr class="separator bottom">

        <div class="row">

            <!-- Column -->
            <div class="col-md-4">
                <strong>Client <?=$formModel->getAttributeLabel('email')?></strong>
                <p class="muted">Client contact email</p>
            </div>
            <!-- // Column END -->

            <?=$form
                ->field($formModel,'email',[
                    'options'=>[
                        'class'=>'col-md-8'
                    ]
                ])
                ->textInput([
                    'placeholder'=>'Enter email here...'
                ])
            ?>

            <div class="separator bottom"></div>

        </div>

        <hr class="separator bottom">

        <div class="row">

            <!-- Column -->
            <div class="col-md-4">
                <strong>Client <?=$formModel->getAttributeLabel('password')?></strong>
                <p class="muted">Password to access</p>
            </div>
            <!-- // Column END -->

            <?=$form
                ->field($formModel,'password',[
                    'options'=>[
                        'class'=>'col-md-8'
                    ]
                ])
                ->passwordInput([
                    'placeholder'=>'Enter password here...'
                ])
            ?>

            <div class="separator bottom"></div>

        </div>

    </div>
</div>

<div class="clearfix"></div>

<div class="buttons pull-right">
    <?=\yii\helpers\Html::submitButton('Submit',['class'=>'btn btn-primary'])?>
</div>

<div class="clearfix"></div>
<div class="separator bottom"></div>

    <div class="widget">
        <div class="widget-head">
            <h4 class="heading glyphicons edit"><i></i>General information</h4>
        </div>

        <div class="widget-body">

            <div class="row">

                <?=$form
                    ->field($formModel,'first_name',[
                        'options'=>[
                            'class'=>'col-md-4'
                        ]
                    ])
                    ->textInput([
                        'placeholder'=>'Enter first name here...',
                    ])
                ?>
                <?=$form
                    ->field($formModel,'last_name',[
                        'options'=>[
                            'class'=>'col-md-4'
                        ]
                    ])
                    ->textInput([
                        'placeholder'=>'Enter last name here...',
                    ])
                ?>
                <?=$form
                    ->field($formModel,'phone',[
                        'options'=>[
                            'class'=>'col-md-4'
                        ]
                    ])
                    ->textInput([
                        'placeholder'=>'Enter phone here...',
                    ])
                ?>

                <div class="clearfix"></div>
                <div class="separator bottom"></div>
            </div>

        </div>
    </div>
    <div class="clearfix"></div>
    <div class="separator bottom"></div>
    <div class="buttons pull-right">
        <?=\yii\helpers\Html::submitButton('Submit',['class'=>'btn btn-primary'])?>
    </div>


    <div class="clearfix" style="height: 50px;"></div>
<? \yii\widgets\ActiveForm::end();?>

