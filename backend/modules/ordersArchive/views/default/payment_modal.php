<?
    use yii\helpers\ArrayHelper;

    \yii\widgets\Pjax::begin(['id'=>'pjax_payment_modal']);
    $this->registerJs('
        $("#orderspayments-payment_type").change(function(){
            if($(this).val()==4) $("#other").show();
            else $("#other").hide();
        });
    ',\yii\web\View::POS_END);
?>



<div class="modal" id="payment_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Добавить оплату заказа</h4>
            </div>
            <? $form=\yii\bootstrap\ActiveForm::begin([
                'id'=>'paymentModel',
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
            <div class="modal-body">

                <?=$form
                    ->field(Yii::$app->controller->payment,'order_id',['options'=>['class'=>'form-group row']])
                    ->hiddenInput(['value'=>$formModel->id])->label(false)
                ?>
                <?=$form
                    ->field(Yii::$app->controller->payment,'transaction_id',['options'=>['class'=>'form-group row']])
                    ->textInput(['placeholder'=>Yii::$app->controller->payment->getAttributePlaceholder('transaction_id')])
                ?>
                <?=$form
                    ->field(Yii::$app->controller->payment,'payment_type',['options'=>['class'=>'form-group row']])
                    ->dropDownList(\backend\modules\orders\models\OrdersPayments::getManualPaymentTypes(),['placeholder'=>$formModel->getAttributePlaceholder('first_name')])
                ?>

                <div id="other" style="display: none;">
                    <?=$form
                        ->field(Yii::$app->controller->payment,'phone',['options'=>['class'=>'form-group row']])
                        ->textInput(['placeholder'=>Yii::$app->controller->payment->getAttributePlaceholder('phone')])
                    ?>
                    <?=$form
                        ->field(Yii::$app->controller->payment,'method',['options'=>['class'=>'form-group row']])
                        ->textInput(['placeholder'=>Yii::$app->controller->payment->getAttributePlaceholder('method')])
                    ?>
                </div>

                <div class="row">
                    <div class="col-md-3"><?=Yii::$app->controller->payment->getAttributeLabel('status')?></div>
                    <div class="col-md-9">
                        <?= $form
                            ->field(Yii::$app->controller->payment, 'status', ['options' => ['style' => 'display:none;']])
                            ->hiddenInput(['value' => 0])->label(false)
                        ?>
                        <?= $form
                            ->field(Yii::$app->controller->payment, 'status',['template' => "{input}\n{hint}\n{error}",'horizontalCssClasses' => [
                                'wrapper' => 'top-minus','offset'=>''
                            ]])->checkbox()->label("");
                        ?>
                    </div>
                </div>

                <?=$form
                    ->field(Yii::$app->controller->payment,'amount',['options'=>['class'=>'form-group row']])
                    ->textInput(['placeholder'=>Yii::$app->controller->payment->getAttributePlaceholder('amount')])
                ?>
<!--                --><?//=$form
//                    ->field(Yii::$app->controller->payment,'real_amount',['options'=>['class'=>'form-group row']])
//                    ->textInput(['placeholder'=>Yii::$app->controller->payment->getAttributePlaceholder('real_amount')])
//                ?>


                <div class="row">
                    <div class="col-md-3"><?=Yii::$app->controller->payment->getAttributeLabel('date')?></div>
                    <div class="col-md-4">
                        <?= $form
                            ->field(Yii::$app->controller->payment, 'date',['template' => "{input}\n{hint}\n{error}",'horizontalCssClasses' => [
                                'wrapper' => 'top-minus','offset'=>''
                            ]])->widget(\wbp\widgets\DatePicker::classname(), [
                                'dateFormat' => 'yyyy-MM-dd',
                                'options' => [
                                    'class' => 'form-control',
                                ],
                                'clientOptions'=>[
                                    'beforeShow'=> new \yii\web\JsExpression("function() {
                                        setTimeout(function(){
                                            $('.ui-datepicker').css('z-index', 99999999999999);
                                        }, 0);
                                    }")
                                ]
                            ])
                        ?>
                    </div>
                    <div class="col-md-4">
<!--                        --><?//= $form
//                            ->field(Yii::$app->controller->payment, 'time',['template' => "{input}\n{hint}\n{error}",'horizontalCssClasses' => [
//                                'wrapper' => 'top-minus','offset'=>''
//                            ]])->textInput(['placeholder'=>'ЧЧ:MM'])->label("");
//                        ?>
                    </div>
                </div>

                <?=$form
                    ->field(Yii::$app->controller->payment,'comment',['options'=>['class'=>'form-group row']])
                    ->textarea(['placeholder'=>Yii::$app->controller->payment->getAttributePlaceholder('comment')])
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




            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Отмена</button>
                <button type="submit" class="btn btn-primary">Добавить платеж</button>
            </div>
                <? \yii\bootstrap\ActiveForm::end(); ?>
        </div>
    </div>
</div>
<? \yii\widgets\Pjax::end(); ?>
