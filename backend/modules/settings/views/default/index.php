<?

$this->title = Yii::t('admin', 'Settings');

$this->params['breadcrumbs'][] = $this->title;
?>
<section class="panel">
    <div class="panel-heading">
        <h3><?=$this->title?></h3>
    </div>


    <? $form=\yii\bootstrap\ActiveForm::begin([
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
                    <h4>Настройки Сайта</h4>
                    <br />



                    <?=$form
                        ->field($formModel,'title',['options'=>['class'=>'form-group row']])
                        ->textInput([
                            'placeholder'=>'Введите насзание сайта...'
                        ])->label('Название сайта')
                    ?>

                    <?=$form
                        ->field($formModel,'email',['options'=>['class'=>'form-group row']])
                        ->textInput([
                            'placeholder'=> Yii::t('admin', 'Введите email...')
                        ])->label('Email сайта')
                    ?>

<!--                    --><?//=$form
//                        ->field($formModel,'address',['options'=>['class'=>'form-group row']])
//                        ->textInput([
//                            'placeholder'=>'Введите адрес...'
//                        ])->label('Адрес');
//                    ?>
<!---->
<!--                    --><?//=$form
//                        ->field($formModel,'how_to_get_there',['options'=>['class'=>'form-group row']])
//                        ->textarea([
//                            'placeholder'=>'Как добраться'
//                        ])->label('Как добраться');
//                    ?>

                    <?=$form
                        ->field($formModel,'phone',['options'=>['class'=>'form-group row']])
                        ->textInput([
                            'placeholder'=>'Введите телефон....'
                        ])->label('Телефоны');
                    ?>

                    <?=$form
                        ->field($formModel,'phone_2',['options'=>['class'=>'form-group row']])
                        ->textInput([
                            'placeholder'=>'Введите телефон...'
                        ])->label('');
                    ?>
                    <?=$form
                        ->field($formModel,'phone_3',['options'=>['class'=>'form-group row']])
                        ->textInput([
                            'placeholder'=>'Введите телефон...'
                        ])->label('');
                    ?>

<!--                    --><?//=$form
//                        ->field($formModel,'skype',['options'=>['class'=>'form-group row']])
//                        ->textInput([
//                            'placeholder'=>'Введите имя skype'
//                        ])->label('Skype');
//                    ?>
<!---->
<!--                    --><?//=$form
//                        ->field($formModel,'viber',['options'=>['class'=>'form-group row']])
//                        ->textInput([
//                            'placeholder'=>'Введите номер телефона viber'
//                        ])->label('Viber');
//                    ?>
<!---->
<!--                    --><?//=$form
//                        ->field($formModel,'work_time',['options'=>['class'=>'form-group row']])
//                        ->textarea([
//                            'placeholder'=>'Введите режим работы'
//                        ])->label('Режим работы');
//                    ?>
<!---->
<!--                    --><?//=$form
//                        ->field($formModel,'copyright',['options'=>['class'=>'form-group row']])
//                        ->textarea([
//                            'placeholder'=>'Введите копирайт'
//                        ])->label('Копирайт');
//                    ?>

                    <div class="form-actions">
                        <div class="form-group row">
                            <div class="col-md-9 col-md-offset-3">
                                <?=\yii\helpers\Html::submitButton('Сохранить',['class'=>'btn width-150 btn-primary'])?>
                                <?=\yii\helpers\Html::resetButton('Отмена',['class'=>'btn btn-default'])?>
                            </div>
                        </div>
                    </div>

                    <h4>Настройки почты (SMTP)</h4>
                    <br />

                    <?=$form
                        ->field($formModel,'smtp_host',['options'=>['class'=>'form-group row']])
                        ->textInput([
                            'placeholder'=>Yii::t('admin', 'Введите smtp хост...')
                        ])
                    ?>

                    <?=$form
                        ->field($formModel,'smtp_user',['options'=>['class'=>'form-group row']])
                        ->textInput([
                            'placeholder'=>Yii::t('admin', 'Введите smtp имя пользователя...')
                        ])
                    ?>

                    <?=$form
                        ->field($formModel,'smtp_password',['options'=>['class'=>'form-group row']])
                        ->textInput([
                            'placeholder'=>Yii::t('admin', 'Введите smtp пароль...')
                        ])
                    ?>

                    <?=$form
                        ->field($formModel,'smtp_port',['options'=>['class'=>'form-group row']])
                        ->textInput([
                            'placeholder'=>Yii::t('admin', 'Введите smtp порт...')
                        ])
                    ?>
                    <?=$form
                        ->field($formModel,'smtp_encryption',['options'=>['class'=>'form-group row']])
                        ->textInput([
                            'placeholder'=>Yii::t('admin', 'Введите encryption...')
                        ])
                    ?>
                    <div class="row">
                        <?= $form
                            ->field($formModel, 'category_id',['options'=>['class'=>'form-group row']])
                            ->dropDownList(
                                \yii\helpers\ArrayHelper::merge(
                                    [0 => 'Категория товара'],
                                    \backend\modules\categories\models\Category::getList('id', 'title', 'id desc'))
                            )
                            ->label("атегория на главной");
                        ?>
                    </div>
                    <h4>Новая почта</h4>
                    <br />

                    <?=$form
                        ->field($formModel,'novaposhta_key',['options'=>['class'=>'form-group row']])
                        ->textInput([
                            'placeholder'=>'Введите ключ доступа...'
                        ])
                    ?>
                    <h4>LiqPay</h4>
                    <br />

                    <?=$form
                        ->field($formModel,'liqpay_public',['options'=>['class'=>'form-group row']])
                        ->textInput([
                            'placeholder'=>'Введите публичный ключ...'
                        ])
                    ?>
                    <?=$form
                        ->field($formModel,'liqpay_private',['options'=>['class'=>'form-group row']])
                        ->textInput([
                            'placeholder'=>'Введите приватный ключ...'
                        ])
                    ?>

                    <div class="row">
                        <div class="col-md-3"><?=$formModel->getAttributeLabel('liqpay_sandbox')?></div>
                        <div class="col-md-9">
                            <?= $form
                                ->field($formModel, 'liqpay_sandbox', ['options' => ['style' => 'display:none;']])
                                ->hiddenInput(['value' => 0])->label(false)
                            ?>
                            <?= $form
                                ->field($formModel, 'liqpay_sandbox',['template' => "{input}\n{hint}\n{error}",'horizontalCssClasses' => [
                                    'wrapper' => 'top-minus','offset'=>''
                                ]])->checkbox()->label("");
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

                </div>
            </div>
        </div>
    </div>
    <? \yii\bootstrap\ActiveForm::end();?>
</section>





