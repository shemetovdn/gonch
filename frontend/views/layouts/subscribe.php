    <?
    $form = \yii\bootstrap\ActiveForm::begin([
//        'enableAjaxValidation' => true,
//        'enableClientValidation' => false,
        'action' => ['site/subscribe'],
        'options'=>['class'=>'form-inline']]);
    ?>
        <div class="form-group">
            <label for="staticEmail2">
                <?=\Yii::t('app', 'Подписывайтесь');?><br>
                <?=\Yii::t('app', 'на наши новости');?>
            </label>
            <?=$form->field($formModel, 'return')->hiddenInput()->label(false);?>

            <?
            echo $form->field($formModel, 'email')->textInput([
                    'class' =>'form-control',
                    'placeholder'=>Yii::t('app', 'Адрес Вашей почты?')
            ])->label(false);
            ?>
        </div>

    <?=\yii\helpers\Html::button(\Yii::t('app', 'Подписаться'), ['type'=>'submit', 'class'=>'btn btn-primary hvr-shutter-in-horizontal'])?>

    <div class="clearfix"></div>
    <?php     \yii\bootstrap\ActiveForm::end();?>
