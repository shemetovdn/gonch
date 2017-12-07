

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
                <h4>Информация</h4>
                <br />

                <?=$form->field($formModel, 'id')->hiddenInput()->label(false)?>


                    <?=$form
                        ->field($formModel,'first_name',['options'=>['class'=>'form-group row']])
                        ->textInput(['placeholder'=>'Введите имя...'])->label($formModel->getAttributeLabel('first_name'))
                    ?>

                    <?=$form
                        ->field($formModel,'last_name',['options'=>['class'=>'form-group row']])
                        ->textInput(['placeholder'=>'Введите фамилию...'])->label($formModel->getAttributeLabel('last_name'))
                    ?>


                    <?=$form
                        ->field($formModel,'position',['options'=>['class'=>'form-group row']])
                        ->textInput(['placeholder'=>'Введите должность...'])->label($formModel->getAttributeLabel('position'))
                    ?>

                    <?=$form
                        ->field($formModel,'phone',['options'=>['class'=>'form-group row']])
                        ->textInput(['placeholder'=>'Введите телефон...'])->label($formModel->getAttributeLabel('phone'))
                    ?>

                    <?=$form
                        ->field($formModel,'email',['options'=>['class'=>'form-group row']])
                        ->textInput(['placeholder'=>'Введите email...'])->label($formModel->getAttributeLabel('email'))
                    ?>

                <div class="row">
                    <div class="col-md-3">Активный / Деактивирован</div>
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

                <div class="form-actions">
                    <div class="form-group row">
                        <div class="col-md-9 col-md-offset-3">
                            <?=\yii\helpers\Html::submitButton('Сохранить',['class'=>'btn width-150 btn-primary'])?>
                            <?=\yii\helpers\Html::resetButton('Отмена',['class'=>'btn btn-default'])?>
                        </div>
                    </div>
                </div>

                <h4>Изображение</h4>
                <br />

                <?php

                echo \wbp\imageUploader\ImageUploader::widget([
                    'style' => 'estoreMultiple',
                    'data' => [
                        'size'=>'123x123',
                    ],
                    'type' => \backend\modules\partners\models\Partners::$imageTypes[0],
                    'item_id' => $formModel->id,
                    'limit' => 1
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