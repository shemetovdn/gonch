

<div class="modal" id="<?=$id?>_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"><?=$title?></h4>
            </div>
            <div class="modal-body">
                <?

                $this->registerJs(<<<JS
                        var focus;
                        function {$id}_filterForm(focus){
                            var data=$('#{$id}_filterForm').serializeArray();

                           $.pjax({
                                url: $('#{$id}_filterForm').attr('action'),
                                container: '#{$id}_listView',
                                method: 'post',
                                data: data,
                                push: false
                           });
                        }
                        
                        $(document).on('keyup', "#{$id}_filterForm input[name='SearchModel[search]']", function(e) {
                            {$id}_filterForm();
                        });
JS
                    , yii\web\View::POS_END);


                ?>
                <? $form = \yii\widgets\ActiveForm::begin(['options' => ['class' => 'form-inline', 'id' => $id.'_filterForm', 'method' => 'POST']]); ?>

                <div class="row">
                    <div class="col-md-6 pull-right">
                        <div class="dataTables_filter">
                            <label class="pull-right">Поиск: <?=$form->field(Yii::$app->controller->searchModel,'search')->textInput(['placeholder'=>'', 'class'=>'form-control input-sm'])->label(false)?></label>
                        </div>
                    </div>
                </div>

                <? \yii\widgets\ActiveForm::end(); ?>
                <?

                \yii\widgets\Pjax::begin(['enablePushState'=>false,'timeout'=>10000,'id'=>$id.'_listView']);

                echo \yii\widgets\ListView::widget(\yii\helpers\ArrayHelper::merge(Yii::$app->params['listView'],[
                    'dataProvider' => Yii::$app->controller->getAllProductsProvider($formModel->id?$formModel->id:false),
                    'itemView' => '_listItemRelated',
                    'layout' => $this->render('@backend/views/parts/listViewLasyout',['columns'=>'
                        <th style="width: 1%;" class="center">ID</th>
                        <th>Фото</th>
                        <th>Имя</th>
                        <th>Размер / Цена</th>
                        <th class="center" style="width: 80px;">Действие</th>
                    ']),

                ]));
                \yii\widgets\Pjax::end();
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Отмена</button>
                <!--                                <button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div>
    </div>
</div>

