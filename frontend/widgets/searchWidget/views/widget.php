<?php
    use \frontend\widgets\SvgWidget\SvgWidget;
    use yii\widgets\ActiveForm;
?>

<a href="#" class="searh"><i class="fa fa-search" aria-hidden="true"></i></a>
<div class="searhblock" id="site-search">
    <?php
    $form = ActiveForm::begin([
        //            'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'id' => 'search',
//        'method'=>'GET',
        'action'=>['site/search']
    ]) ?>
    <?= $form->field($model, 'q')->textInput(['placeholder' => \Yii::t('app', 'Поиск').'...'])->label(false)?>

    <div class="positionclose" style="cursor: pointer;">
        <?=SvgWidget::getSvgIcon('+')?>
    </div>
    <? ActiveForm::end(); ?>
</div>

