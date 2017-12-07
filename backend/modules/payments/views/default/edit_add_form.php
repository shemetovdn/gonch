<?
use yii\helpers\ArrayHelper;

$this->registerJs('
    $("#orderspayments-payment_type").change(function(){
        if($(this).val()==4) $("#other").show();
        else $("#other").hide();
    });
',\yii\web\View::POS_END);

?>

<? $form=\yii\bootstrap\ActiveForm::begin([
    'id'=>'orderForm',
    'layout' => 'horizontal',
    'fieldConfig' => [
        'template' => "<div class=\"col-md-3\">\n{label}\n</div>\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
        'horizontalCssClasses' => [
            'label' => 'form-control-label',
            'offset' => 'col-sm-offset-4',
            'wrapper' => 'col-md-9',
            'error' => '',
            'hint' => '',
        ],
    ],
]); ?>

<div class="panel-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="margin-bottom-50">
                <h4>Информация о платеже</h4>
                <br />
                <?=$form
                    ->field($formModel,'order_id',['options'=>['class'=>'form-group row']])
                    ->dropDownList(\backend\modules\orders\models\Orders::getList('id','id','id'))
                ?>
                <?=$form
                    ->field($formModel,'transaction_id',['options'=>['class'=>'form-group row']])
                    ->textInput(['placeholder'=>$formModel->getAttributePlaceholder('transaction_id')])
                ?>
                <?=$form
                    ->field($formModel,'payment_type',['options'=>['class'=>'form-group row']])
                    ->dropDownList(\backend\modules\orders\models\OrdersPayments::getManualPaymentTypes(),['placeholder'=>$formModel->getAttributePlaceholder('first_name')])
                ?>
                <div id="other" style="display: none;">
                    <?=$form
                        ->field($formModel,'phone',['options'=>['class'=>'form-group row']])
                        ->textInput(['placeholder'=>$formModel->getAttributePlaceholder('phone')])
                    ?>
                    <?=$form
                        ->field($formModel,'method',['options'=>['class'=>'form-group row']])
                        ->textInput(['placeholder'=>$formModel->getAttributePlaceholder('method')])
                    ?>
                </div>

                <div class="row">
                    <div class="col-md-3"><?=$formModel->getAttributeLabel('status')?></div>
                    <div class="col-md-9">
                        <?= $form
                            ->field($formModel, 'status', ['options' => ['style' => 'display:none;']])
                            ->hiddenInput(['value' => 0])->label(false)
                        ?>
                        <?= $form
                            ->field($formModel, 'status',['template' => "{input}\n{hint}\n{error}",'horizontalCssClasses' => [
                                'wrapper' => 'top-minus','offset'=>''
                            ]])->checkbox()->label("");
                        ?>
                    </div>
                </div>

                <?=$form
                    ->field($formModel,'amount',['options'=>['class'=>'form-group row']])
                    ->textInput(['placeholder'=>$formModel->getAttributePlaceholder('amount')])
                ?>
<!--                --><?//=$form
//                    ->field($formModel,'real_amount',['options'=>['class'=>'form-group row']])
//                    ->textInput(['placeholder'=>$formModel->getAttributePlaceholder('real_amount')])
//                ?>


                <div class="row">
                    <div class="col-md-3"><?=$formModel->getAttributeLabel('date')?></div>
                    <?php if($formModel->payment_type == 1){?>
                    <div class="col-md-4">
                        <?= $form
                            ->field($formModel, 'date',['template' => "{input}\n{hint}\n{error}",'horizontalCssClasses' => [
                                'wrapper' => 'top-minus','offset'=>''
                            ]])->widget(\wbp\widgets\DatePicker::classname(), [
                                'dateFormat' => 'yyyy-MM-dd',
                                'options' => [
                                    'class' => 'form-control',
                                ]
                            ])
                        ?>
                    </div>
                    <?php }?>
                    <?php if($formModel->payment_type == 0){?>
                        <div class="col-md-4">
                            <?= $form
                                ->field($formModel, 'time',['template' => "{input}\n{hint}\n{error}",'horizontalCssClasses' => [
                                    'wrapper' => 'top-minus','offset'=>''
                                ]])->textInput(['placeholder'=>'ГГ-ММ-ЧЧ ЧЧ:MM:СС', 'readonly'=>true])->label("");
                            ?>
                        </div>
                    <?php }?>

                </div>


                <?=$form
                    ->field($formModel,'comment',['options'=>['class'=>'form-group row']])
                    ->textarea(['placeholder'=>$formModel->getAttributePlaceholder('comment')])
                ?>

                <h4>Фото</h4>

                <?php

                echo \wbp\imageUploader\ImageUploader::widget([
                    'style' => 'estoreMultiple',
                    'data' => [
                        'size' => '123x123',
                    ],
                    'type' => \backend\modules\orders\models\OrdersPayments::$imageTypes[0],
                    'item_id' => $formModel->id,
                    'limit' => 999
                ]);

                ?>


                <div class="clearfix"></div>

                <div class="form-actions">
                    <div class="form-group row">
                        <div class="col-md-9 col-md-offset-3">
                            <?=\yii\helpers\Html::submitButton('Сохранить',['class'=>'btn width-150 btn-primary'])?>
                            <?=\yii\helpers\Html::resetButton('Отмена',['class'=>'btn btn-default'])?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<? \yii\bootstrap\ActiveForm::end(); ?>
