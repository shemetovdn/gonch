<?
use wbp\widgets\GridInput;

$left_col = 3;
$right_col = 9;

?>

<? $form=\yii\widgets\ActiveForm::begin(); ?>

<div class="widget">
    <div class="widget-head">
        <h4 class="heading glyphicons tint"><i></i>Item info</h4>
    </div>
    <div class="widget-body">

        <?=GridInput::help($form->field($formModel, 'fname')->textInput(['disabled' => 'disabled'])->label(false), 'Name', '', $left_col, $right_col, true)?>

        <?=GridInput::help($form->field($formModel, 'email')->textInput(['disabled' => 'disabled'])->label(false), 'Email', '', $left_col, $right_col, true)?>

        <?=GridInput::help($form->field($formModel, 'phone')->textInput(['disabled' => 'disabled'])->label(false), 'Phone', '', $left_col, $right_col, true)?>

        <?=GridInput::help($form->field($formModel, 'message')->textarea(['rows' => 5, 'style' => 'resize: none;', 'disabled' => 'disabled'])->label(false), 'Message', '', $left_col, $right_col, true)?>

        <?=GridInput::help($form->field($formModel, 'answer')->textarea(['rows' => 5, 'style' => 'resize: none;'])->label(false), 'Answer', '', $left_col, $right_col, true)?>


    </div>
</div>

<div class="clearfix"></div>
<div class="separator bottom"></div>


<div class="buttons pull-right">
    <?=\yii\helpers\Html::submitButton('Submit',['class'=>'btn btn-primary'])?>
</div>

<div class="clearfix" style="height: 50px;"></div>
<? \yii\widgets\ActiveForm::end();?>

