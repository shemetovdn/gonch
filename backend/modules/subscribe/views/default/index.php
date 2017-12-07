<?
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = "Подписчики";
$this->params['breadcrumbs'][] = $this->context->title;

?>
<style>
    .buttons.pull-right span{
        margin: 5px;
    }
</style>

<div class="separator bottom"></div>
<!-- Widget -->
<div class="innerLR">

    <div class="widget">

        <div class="widget-head">
            <h4 class="heading glyphicons list"><i></i> <?= $this->title ?></h4>
        </div>

        <div class="widget-body" style="padding: 0;">
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

                        
                         //$('.readajax').on('click', function(){
                         //   var el = $(this);
                         //   var href = el.attr('href')
                         //   $.get(href, {}, function(result){
                         //       el.replaceWith(result);
                         //       console.debug(result);
                         //   });
                         //   return false;
                         //});
JS
                , yii\web\View::POS_END);

            ?>
            <div style="padding: 10px;">
                <?
                Pjax::begin(['id' => 'listView', 'options'=>['class' => 'pjax-container']]);

                echo ListView::widget([
                    'dataProvider' => $dataProvider,
                    'summary' => '<div class="summary small separator bottom">Showing {begin}-{end}</div>',
                    'itemOptions' => ['tag'=>'tr','class'=>'selectable'],
                    'pager'=> [
                        'class'=>\yii\widgets\LinkPager::className(),
                        'options'=>[
                            'class'=>'pagination pagination-right margin-none pull-right'
                        ]
                    ],
                    'layout' => '
                                    {summary}
                                    <table id="sortable" class="table table-bordered table-condensed table-striped table-primary table-vertical-center checkboxs js-table-sortable ui-sortable">
                                        <thead>
                                            <tr>
                                                <th style="width: 1%;" class="center">ID</th>
                                                <th style="width: 10%;" class="center">Email</th>
                                                <th style="width: 10%;" class="center">Date</th>
                                                <th class="center" style="width: 15%;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {items}
                                        </tbody>
                                    </table>
                                    <div class="separator top form-inline small">
                                        {pager}
                                    </div>
                                    ',
                    'itemView' => '_listItem'

                ]);
                if(\Yii::$app->controller->sortEnable()) {

                    \yii\jui\Sortable::widget([
                        'options' => ['id' => 'sortable tbody'],
                        'clientOptions' => ['cursor' => 'move', 'items' => ' > tr'],
                        'clientEvents' => [
                            'update' => "function(event, ui){
                                        $.post(
                                            '" . \yii\helpers\Url::to(['sort']) . "',
                                            {elements:$(this).sortable('toArray',{attribute:'data-key'})}
                                        );
                                      }"
                        ]
                    ]);
                }
                Pjax::end();
                ?>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<!-- // Widget END -->





