<?
use backend\modules\orders\models\OrdersPayments;
use wbp\widgets\RemoveButton;
use backend\modules\clients\models\Client;
use yii\helpers\ArrayHelper;

$this->registerJs('
        $("#orders-shipping_method").change(function(){
            if($(this).val()==0){
                $(".field-orders-delivery_office").show();
                $(".field-orders-city.cityNp").show();
                $(".field-orders-address").hide();               
                $(".field-orders-city.city").hide();
                $(".field-orders-city.city input#orders-city").prop("disabled", true);
            }else{
                $(".field-orders-address").show();
                $(".field-orders-city.city").show();
//                $(".field-orders-city.cityNp").hide();
                $(".field-orders-city.city input#orders-city").prop("disabled", false);
                $(".field-orders-delivery_office").hide();
            }
            recalc();
        }).change();
        
        
        
        $("#orders-country_id").change(function(){
            $.pjax.reload({"container":"#pjax_country","history":false, "data":{"Orders[country_id]":$("#orders-country_id").val()}});
        }).change();
        
        $("#pjax_country").on("pjax:success", function(event, data, status, xhr, options) {
            $("#pjax_country #orders-city").change();
         });
        
        $(document).on("change", "#orders-discount_code", function(){
            recalc();
        });
        $(document).on("change", "#pjax_country #orders-city", function(){
            $.pjax.reload({"container":"#pjax_office","timeout": 5000, "history":false,"data":{"Orders[city]":$(this).val()}});
        });
        
        $("#pjax_office").on("pjax:success", function(event, data, status, xhr, options) {
            $("#orders-shipping_method").change();
         });
         
         $("#orders-currency_id").change(function(){
            recalc();
         })
         
         $("#orders-client_id").change(function(){
            $.ajax({url: "'.\yii\helpers\Url::to(['get-client-info']).'", data: {id: $(this).val()}, success: function(result){
                if(!result) return;
                result=JSON.parse(result);
                if(!$("#orders-first_name").val()) $("#orders-first_name").val(result["first_name"]);
                if(!$("#orders-last_name").val()) $("#orders-last_name").val(result["last_name"]);
                if(!$("#orders-phone").val()) $("#orders-phone").val(result["phone"]);
            }})
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
                <div class="row">
                    <div class="col-md-6">
                        <? if($formModel->status==\backend\modules\orders\models\Orders::STATUS_SHIPPED){?>
                            <br />
                            <br />
                            <br />
                        <? } ?>
                        <?
                            echo $form
                            ->field($formModel,'client_id',['options'=>['class'=>'form-group row']])
                            ->dropDownList(ArrayHelper::merge(['Выберите'],Client::getList('id','username', 'id')),['placeholder'=>$formModel->getAttributePlaceholder('client_id')])
                        ?>

                        <?=$form
                            ->field($formModel,'comment',['options'=>['class'=>'form-group row']])
                            ->textarea(['placeholder'=>$formModel->getAttributePlaceholder('comment')])
                        ?>
                    </div>
                    <? if($formModel->status==\backend\modules\orders\models\Orders::STATUS_SHIPPED){?>
                        <div class="col-md-6">
                            <h4>Информация о посылке</h4>
                            <br />
                            <?=$form
                                ->field($formModel,'shipping_id',['options'=>['class'=>'form-group row']])
                                ->textInput(['placeholder'=>$formModel->getAttributePlaceholder('shipping_id')])
                            ?>
                            <div class="row">
                                <div class="col-md-3"><?=$formModel->getAttributeLabel('shipping_date')?></div>
                                <div class="col-md-9">
                                    <?= $form
                                        ->field($formModel, 'shipping_date',['template' => "{input}\n{hint}\n{error}",'horizontalCssClasses' => [
                                            'wrapper' => 'top-minus','offset'=>''
                                        ]])->widget(\wbp\widgets\DatePicker::classname(), [
                                            'dateFormat' => 'yyyy-MM-dd',
                                            'options' => [
                                                'class' => 'form-control',
                                            ]
                                        ])
                                    ?>
                                </div>
                            </div>

                            <?=$form
                                ->field($formModel,'shipping_price',['options'=>['class'=>'form-group row']])
                                ->textInput(['placeholder'=>$formModel->getAttributePlaceholder('shipping_price')])
                            ?>
                            <?=$form
                                ->field($formModel,'shipping_weight',['options'=>['class'=>'form-group row']])
                                ->textInput(['placeholder'=>$formModel->getAttributePlaceholder('shipping_weight')])
                            ?>
                            <?=$form
                                ->field($formModel,'shipping_comment',['options'=>['class'=>'form-group row']])
                                ->textarea(['placeholder'=>$formModel->getAttributePlaceholder('shipping_comment')])
                            ?>
                        </div>
                    <? } ?>
                </div>

                <div class="form-actions">
                    <div class="form-group row">
                        <div class="col-md-9 col-md-offset-3">
                            <?=\yii\helpers\Html::submitButton('Сохранить',['class'=>'btn width-150 btn-primary'])?>
                            <?=\yii\helpers\Html::resetButton('Отмена',['class'=>'btn btn-default'])?>
                        </div>
                    </div>
                </div>
                <br />
                <br />
                <div class="row">
                    <div class="col-md-6">
                        <h4>Информация о получателе</h4>
                        <br />
                        <?=$form
                            ->field($formModel,'first_name',['options'=>['class'=>'form-group row']])
                            ->textInput(['placeholder'=>$formModel->getAttributePlaceholder('first_name')])
                        ?>
                        <?=$form
                            ->field($formModel,'last_name',['options'=>['class'=>'form-group row']])
                            ->textInput(['placeholder'=>$formModel->getAttributePlaceholder('last_name')])
                        ?>
                        <?=$form
                            ->field($formModel,'phone',['options'=>['class'=>'form-group row']])
                            ->textInput(['placeholder'=>$formModel->getAttributePlaceholder('phone')])
                        ?>
                    </div>
                    <div class="col-md-6">
                        <h4>Информация о доставке</h4>
                        <br />
<!---->
<!--                        --><?//=$form
//                            ->field($formModel,'country_id',['options'=>['class'=>'form-group row']])
//                            ->dropDownList(\backend\models\Countries::getList('id','title', 'title',['shipping'=>1]),['placeholder'=>$formModel->getAttributePlaceholder('country_id')])
//                        ?>
                        <?=$form
                            ->field($formModel,'shipping_method',['options'=>['class'=>'form-group row']])
                            ->dropDownList(\backend\modules\orders\models\Orders::getShippingList(),['placeholder'=>$formModel->getAttributePlaceholder('shipping_method')])
                        ?>
                        <? \yii\widgets\Pjax::begin(['id'=>'pjax_country']); ?>

                                <?=$form
                                    ->field($formModel,'city',['options'=>['class'=>'form-group row cityNp']])
                                    ->dropDownList(Yii::$app->controller->novaposhta->getAllCities(), ['placeholder'=>$formModel->getAttributePlaceholder('city')])
                                ?>

                        <? \yii\widgets\Pjax::end(); ?>
<!--                        --><?//=$form
//                            ->field($formModel,'city',['options'=>['class'=>'form-group row city']])
//                            ->textInput([
//                                    'placeholder'=>$formModel->getAttributePlaceholder('city'),
//                                'class'=>"form-control city",
//                                'value'=>$formModel->shipping_method == 1? $formModel->city:"",
//                                'disabled'=>$formModel->shipping_method == 1? false:true
//                            ])
//                        ?>

                        <? \yii\widgets\Pjax::begin(['id'=>'pjax_office']); ?>
                                <?=$form
                                    ->field($formModel,'delivery_office',['options'=>['class'=>'form-group row']])
                                    ->dropDownList(Yii::$app->controller->novaposhta->getAllWarehouses(Yii::$app->request->get('Orders')['city']),['placeholder'=>$formModel->getAttributePlaceholder('delivery_office')])
                                ?>

                        <? \yii\widgets\Pjax::end(); ?>
                        <?=$form
                            ->field($formModel,'address',['options'=>['class'=>'form-group row']])
                            ->textInput(['placeholder'=>$formModel->getAttributePlaceholder('address')])
                        ?>

                    </div>
                </div>


                <div class="form-actions">
                    <div class="form-group row">
                        <div class="col-md-9 col-md-offset-3">
                            <?=\yii\helpers\Html::submitButton('Сохранить',['class'=>'btn width-150 btn-primary'])?>
                            <?=\yii\helpers\Html::resetButton('Отмена',['class'=>'btn btn-default'])?>
                        </div>
                    </div>
                </div>

                <?=$this->render('products_selector',[
                    'id'=>'products',
                    'title'=>'Товары',
                    'field_name'=>'products',
                    'selected'=>$formModel->productsLinks,
                    'product_obj'=>'product',
                    'formModel'=>$formModel
                ])?>


                <? \yii\widgets\Pjax::begin(['id'=>'totals']) ?>

                <div class="row">
<!--                    <div class="col-md-6">-->
<!--                        --><?//=$form
//                            ->field($formModel,'discount_code',['options'=>['class'=>'form-group row']])
//                            ->textInput(['placeholder'=>$formModel->getAttributePlaceholder('discount_code')])
//                        ?>
<!--                    </div>-->
                    <div class="col-md-4 pull-right">
                        <h4>Всего:</h4>
                        <div class="clearfix"></div>
                        <div class="row" style="font-size: 18px;">
                            <div class="col-md-8">
                                <span>Стоимость товаров:</span>
                            </div>
                            <div class="col-md-4 text-right">
                                <?=$formModel->getSubTotal()?>
                            </div>
                            <div class="clearfix"></div>
<!--                            <div class="col-md-8">-->
<!--                                <span>Скидка--><?// if($formModel->getDiscount()) echo ' ('.$formModel->getDiscount()->getTextValue().')'?><!--:</span>-->
<!--                            </div>-->
<!--                            <div class="col-md-4 text-right">-->
<!--                                --><?//=$formModel->getDiscountPrice()?>
<!--                            </div>-->
                            <div class="clearfix"></div>
                            <div class="col-md-8">
                                <span>Доставка:</span>
                            </div>
                            <div class="col-md-4 text-right">
                                <?=$formModel->getShippingPrice()?>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-8">
                                <span>Итого:</span>
                            </div>
                            <div class="col-md-4 text-right">
<?//=$formModel->getTotal()?>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-8">
                                <span>Оплаченно:</span>
                            </div>
                            <div class="col-md-4 text-right">
                                <?=$formModel->getPaid()?>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-8">
                                <span>Баланс:</span>
                            </div>
                            <div class="col-md-4 text-right">
                                <?=$formModel->getBalance()?>
                            </div>
                        </div>
                    </div>
                </div>

                <? \yii\widgets\Pjax::end(); ?>


                <div class="clearfix"></div>

                <div class="form-actions">
                    <div class="form-group row">
                        <div class="col-md-9 col-md-offset-3">
                            <?=\yii\helpers\Html::submitButton('Сохранить',['class'=>'btn width-150 btn-primary'])?>
                            <?=\yii\helpers\Html::resetButton('Отмена',['class'=>'btn btn-default'])?>
                        </div>
                    </div>
                </div>
<?
    if($formModel->id){
?>
                <h4 class="pull-left">Платежи</h4>
                <p class="btn btn-success pull-right" style="margin-bottom: 0;" data-toggle="modal" data-target="#payment_modal">Добавить платеж</p>
                <div class="clearfix"></div>
                <br />

                <? \yii\widgets\Pjax::begin(['id'=>'payments']); ?>

                <table class="table table-hover nowrap js-table-sortable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Номер платежа</th>
                            <th>Тип платежа</th>
                            <th>Сумма</th>
                            <th>Дата</th>
                            <th>Комментарий</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="products_block" class="ui-sortable">
                        <?
                            foreach ($formModel->payments as $payment){
                                $color="color: #C6A35D;";
                                if($payment->status==OrdersPayments::STATUS_RECEIVED) $color="color: #46be8a;";
                        ?>
                            <tr style="<?=$color?>">
                                <td><?= $payment->id?></td>
                                <td><?= $payment->transaction_id?></td>
                                <td><?= OrdersPayments::$paymentTypes[$payment->payment_type]?></td>
                                <td><?= $payment->amount?></td>
                                <td><?= $payment->date?> <?= $payment->time?></td>
                                <td><?= $payment->comment?></td>
                                <td width="100" class="center">
                                    <div class="btn-group btn-actions" aria-label="" role="group" style="">
                                        <a href="<?=\yii\helpers\Url::to(['/payments/default/edit','id'=>$payment->id])?>" data-pjax="false" class="btn btn-success">
                                            <i class="icmn-pencil" aria-hidden="true"></i>
                                        </a>
                                        <?=RemoveButton::widget([
                                            'linkOptions'=>[
                                                'text' => '<i class="icmn-bin" aria-hidden="true"></i>',
                                                'url' => ['/payments/default/remove','id'=>$payment->id],
                                                'options' => ['class'=>'btn btn-danger']
                                            ],
                                            'ajax'=>true,
                                            'pjaxContainer'=>'#payments',
                                        ]);
                                        ?>
                                    </div>


                                </td>
                            </tr>
                        <? } ?>
                    </tbody>
                </table>

                <? \yii\widgets\Pjax::end();?>


                <div class="clearfix"></div>

                <div class="form-actions">
                    <div class="form-group row">
                        <div class="col-md-9 col-md-offset-3">
                            <?=\yii\helpers\Html::submitButton('Сохранить',['class'=>'btn width-150 btn-primary'])?>
                            <?=\yii\helpers\Html::resetButton('Отмена',['class'=>'btn btn-default'])?>
                        </div>
                    </div>
                </div>
<?php
    }
?>

            </div>
        </div>
    </div>
</div>

<? \yii\bootstrap\ActiveForm::end(); ?>

<?=$this->render('products_modal',[
    'id'=>'products',
    'formModel'=>$formModel,
    'title'=>'Добавить рекомендуемый товар',
])?>

<?=$this->render('payment_modal',[
    'id'=>'products',
    'formModel'=>$formModel,
    'title'=>'Добавить рекомендуемый товар',
])?>

<?
    $this->registerJs('
            $(document).on("submit","#paymentModel",function(e){
                e.preventDefault();
                $.ajax({url:"'.\yii\helpers\Url::to(['/payments/default/add']).'", method: "post", data: $("#paymentModel").serialize(), success: function(){
                    $("#payment_modal").modal("hide");
                    $.pjax.reload({container: "#pjax_payment_modal", history: false});
                }});
            })
            
            $("#pjax_payment_modal").on("pjax:success", function(event, data, status, xhr, options) {
                $.pjax.reload({container: "#payments", history: false});
            });
            $("#payments").on("pjax:success", function(event, data, status, xhr, options) {
                recalc();
            }); 
        ',\yii\web\View::POS_END);
?>

