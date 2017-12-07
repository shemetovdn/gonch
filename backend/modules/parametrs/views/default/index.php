<?
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = Yii::$app->controller->module->text['module_name'];

$this->params['breadcrumbs'][] = $this->title;

$this->registerJs(
     '
    $( "#sortable tbody" ).sortable({
            change:  function (event, ui) {
            var currPos2 = ui.item.index();
            var paramers = $("#sortable .paramert_id");           
        }
    });
    $( "#sortable  tbody" ).disableSelection();

', yii\web\View::POS_READY);
?>
<style>
    .ui-sortable-handle{
        cursor: move;
    }
    
</style>

<section class="panel">
    <div class="panel-heading">
        <h3 class="pull-left"><?=$this->title?></h3>
        <?=Html::a('<i></i>'.Yii::$app->controller->module->text['add_item'], ['add'],['class'=>'btn btn-primary pull-right'])?>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-bottom-50">


                    <?
                    $this->registerJs(<<<JS
                        var focus;
                        function filterForm(focus){
                            var data=$('#filterForm').serializeArray();

                           $.pjax({
                                url: $('#filterForm').attr('action'),
                                container: '#listView',
                                data: data,
                                push: false
                           });
                        }
                        $(document).on('change', '#filterForm input, #filterForm select', function(e) {
                            //focus=$();
                            filterForm();
                        });
                        $(document).on('keyup', "#filterForm input[name='SearchModel[search]']", function(e) {
                            focus=$(this);
                            filterForm();
                        });
                         $('#listView').on('pjax:success', function(event, data, status, xhr, options) {
                            focus.focus();
                         });

JS
                        , yii\web\View::POS_END);

                    ?>

                    <? $form = \yii\widgets\ActiveForm::begin(['action'=>['/parametrs/default/index'],'options' => ['class' => 'form-inline', 'id' => 'filterForm', 'method' => 'POST']]); ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="dataTables_length" id="example1_length">
                                <label>
                                    Показанно <?=$form->field($searchModel,'per_page',['options'=>['class'=>'','style'=>'display:inline-block;']])->dropDownList(\backend\modules\parametrs\models\SearchModel::$pageSizeList,['placeholder'=>'', 'class'=>'form-control input-sm', 'style'=>'width:65px;'])->label(false)?> <?=$searchModel->per_page==-1?'записи':'записей'?>
                                </label>
                            </div>
                        </div>
<!--                        <div class="col-md-6">-->
<!--                            <div class="dataTables_filter">-->
<!--                                <label class="pull-right">Поиск: --><?//=$form->field($searchModel,'search')->textInput(['placeholder'=>'', 'class'=>'form-control input-sm'])->label(false)?><!--</label>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>

                    <? \yii\widgets\ActiveForm::end(); ?>

                    <div class="dataTables_wrapper form-inline dt-bootstrap4">
                        <?
                        Pjax::begin(['id' => 'listView', 'options'=>['class' => 'pjax-container']]);

                        echo \yii\widgets\ListView::widget(\yii\helpers\ArrayHelper::merge(Yii::$app->params['listView'],[
                            'dataProvider' => $dataProvider,
                            'layout' => $this->render('@backend/views/parts/listViewLasyout',['columns'=>'
                                <th style="width: 1%;" class="center">ID</th>
                                <th>Имя</th>
                                <th class="center" style="width: 80px;">Действие</th>
                            ']),

                        ]));

                        echo $this->render('@backend/views/parts/sorter');
                        Pjax::end();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>