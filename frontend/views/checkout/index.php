<?php
use yii\helpers\Url;
use yii\widgets\ListView;
use \frontend\widgets\SvgWidget\SvgWidget;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
$bundle = \frontend\assets\AppAsset::register($this);
$this->title = \Yii::t('app', 'Оформление заказа');
$novaPoshta = new \backend\modules\orders\models\NovaPoshta();
$first_name = "";
$last_name = "";
$email = "";
$phone = "";
$city = '';
$client_id = "";
if(!empty($user)){
    $first_name = $user->first_name;
    $last_name = $user->last_name;
    if(!empty($user->email)){$email = $user->email;}
    if(!empty($user->phone)){$phone = $user->phone;}
    if(!empty($user->city)){$city = $user->city;}
    $client_id = $user->id;
}
?>
<style>
    .name-page:before{
        display: none;
    }
</style>
<div class="name-page"><?=\Yii::t('app', 'Оформление заказа')?></div>
<div class="clearfix"></div>
<div class="somelinecontent"></div>

<div class="row">
    <div class="col-md-6">

        <? $form=ActiveForm::begin([
            'enableClientValidation' => true,
            'id' => 'order_form',
        ]); ?>

            <div class="name-title"><?=\Yii::t('app', 'Контактне данные покупателя')?>:</div>

            <div class="row">
                <div class="col-sm-6">
                    <?=$form->field($orderForm,'first_name')->textInput([
                        'placeholder' =>\Yii::t('app', 'Ваше имя?'),
                        'value' => $first_name
                    ])->label(\Yii::t('app', 'Как к Вам обращаться').":");
                    ?>
                    <?=$form->field($orderForm,'client_id')->hiddenInput([
                        'value' => $client_id
                    ])->label(false);
                    ?>
                </div>
                <div class="col-sm-6">
                    <?=$form->field($orderForm,'last_name')->textInput([
                        'placeholder' =>\Yii::t('app', 'Ваша фамилия?'),
                        'value' => $last_name
                    ])->label("", ['class'=>'hidden-xs']);
                    ?>
                </div>
            </div>



            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <?=$form->field($orderForm,'email')->textInput([
                            'placeholder' =>'mail@exemple.com',
                            'value' => $email
                        ])->label(\Yii::t('app', 'Электронная почта').":");
                        ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <?=$form->field($orderForm,'phone')->textInput([
                            'placeholder' => "+380 ( _ _ ) _ _ _ - _ _ - _ _",
                            'value' => $phone
                        ])->label(\Yii::t('app', 'Номер Вашего телефона').":");
                        ?>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="name-title"><?=\Yii::t('app', 'Информация для доставки')?>:</div>

            <div class="row">
                <div class="col-sm-6">
                    <?=$form
                        ->field($orderForm,'shipping_method')
                        ->dropDownList(\backend\modules\orders\models\Orders::getShippingList(),['placeholder'=>$orderForm->getAttributePlaceholder('shipping_method')])
                        ->label(Yii::t('app', 'Выберите способ доставки').':');
                    ?>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <?=$form
                            ->field(Yii::$app->controller->payment,'payment_type')
                            ->dropDownList(\backend\modules\orders\models\OrdersPayments::getManualPaymentTypes(),['placeholder'=>$orderForm->getAttributePlaceholder('first_name')])
                            ->label('Выберите способ оплаты:');
                        ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($orderForm, 'city')
                        ->dropDownList(
                            \yii\helpers\ArrayHelper::merge(
                                ['' => \Yii::t('app', 'Выберите населенный пункт')],
                                $novaPoshta->getAllCities()),
                            [
                                'class' => 'form-control'
                            ]
                        )
                        ->label(\Yii::t('app', 'Выберите отделение').':');
                    ?>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <?= $form
                            ->field($orderForm, 'delivery_office', ['options'=>['data-shipping'=>"0"]])
                            ->dropDownList(
                                ['' => \Yii::t('app', 'Выберите отделение')],
                                [
                                    'class' => 'form-control',
                                    'id' => 'delivery_office'
                                ]
                            )
                            ->label('', ['class'=>'hidden-xs']);
                        ?>
                        <?=$form->field($orderForm,'address', ['options'=>['data-shipping'=>"1", 'style'=>'display: none;']])
                            ->textInput(['placeholder' => \Yii::t('app', 'Адрес'),
                            ])->label('', ['class'=>'hidden-xs']);
                        ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <?=$form->field($orderForm,'comment')->textarea([
                    'placeholder' => \Yii::t('app', 'Ваше сообщение'),
                ])->label(\Yii::t('app', 'Ваш комментарий к заказу').":");
                ?>
            </div>

        <? \yii\widgets\ActiveForm::end();?>
    </div>
    <div class="col-md-6">
        <div class="name-title">Ваш заказ:</div>
        <?php Pjax::begin(['id' => 'checkoutPjax']); ?>

<!--        <div class="dev-cart-list">-->
<!--            <div class="row head hidden-sm hidden-xs">-->
<!--                <div class="column column-1 title" style="width: 48%;">--><?//=\Yii::t('app', 'Наименование товара')?><!--:</div>-->
<!--                <div class="column column-3 title">--><?//=\Yii::t('app', 'Артикул')?><!--:</div>-->
<!--                <div class="column column-4 title">--><?//=\Yii::t('app', 'Количество')?><!--:</div>-->
<!--                <div class="column column-5 title">--><?//=\Yii::t('app', 'Цена')?><!--:</div>-->
<!--                <div class="column column-6 title">--><?//=\Yii::t('app', 'К оплате')?><!--:</div>-->
<!--                <div class="column column-7"></div>-->
<!--            </div>-->
<!--            --><?//=$this->render('checkout-list-view-dev',['dataProvider'=>$dataProvider])?>
<!--        </div>-->

        <div class="dev-cart-list visible-xs">
            <?=$this->render('checkout-list-view-dev',['dataProvider'=>$dataProvider])?>
        </div>


        <div class="hidden-xs">
            <table id="cart" class="table table-hover table-condensed">
                <thead>
                    <tr>
                        <th width="50%"><?=\Yii::t('app', 'Наименование товара')?>:</th>
                        <th width="20%" class=" hidden-xs"><?=\Yii::t('app', 'Количество')?>:</th>
                        <th width="25%" class=" hidden-xs"><?=\Yii::t('app', 'К оплате')?>:</th>
                        <th width="5%" class=" hidden-xs"></th>
                    </tr>
                </thead>

                <?=$this->render('checkout-list-view',['dataProvider'=>$dataProvider])?>
            </table>

        </div>

        <table class="totaltable">

            <tr>
                <td class="wid-check-1"></td>
                <td class="n-table-2 text-center finaltotal"><?=\Yii::t('app', 'Итого')?>:<span><span id="totalCost"></span> грн</span></td>

            </tr>
            <tr>
                <td class="wid-check-1"></td>
                <td class="wid-check text-center">
                    <?=\yii\helpers\Html::submitButton(\Yii::t('app', 'Оформить заказ'),['class'=>'btn btn-success btn-block hvr-shutter-in-horizontal'])?>
                </td>
            </tr>
        </table>

        <?php Pjax::end(); ?>

    </div>
</div>

</div>
<!---->
<!--<pre>-->
<?php
//if(!Yii::$app->session->isActive){Yii::$app->session->open();}
//
//var_dump(Yii::$app->session->get('cart'));?>
<!---->
<!--</pre>-->
