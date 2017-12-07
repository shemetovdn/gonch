<?
use backend\modules\orders\models\OrdersPayments;
use yii\helpers\Html;
use wbp\widgets\RemoveButton;

\wbp\ajaxer\AjaxerAsset::register($this);

if($model->status==OrdersPayments::STATUS_RECEIVED) $color="color: #46be8a;";

$this->registerJs('
    function reload(){
        $.pjax.reload({container:"#listView",history:false});
    }
',\yii\web\View::POS_END,'reloader');

//if(!$model->status){ $bg = "background-color: #e69b9b;"; }
?>
<td class="center" style="<?=$color?>"><?= $model->id ?></td>
<td style="<?=$color?>"><?= $model->order->orderName?></td>
<td style="<?=$color?>"><?= $model->transaction_id?></td>
<td style="<?=$color?>"><?= \backend\modules\orders\models\OrdersPayments::$paymentTypes[$model->payment_type]?></td>
<td style="<?=$color?>"><?= $model->amount.$model->currency->sign?><?if($model->real_amount){?> (<?=$model->real_amount.$model->currency->sign?>)<?}?></td>
<td style="<?=$color?>"><?= $model->date?> <?= $model->time?></td>
<td class="center" style="<?=$bg?>width:120px;">
    <div class="btn-group btn-actions" aria-label="" role="group"><?
            echo Html::a('<i class="icmn-pencil" aria-hidden="true"></i>',['edit','id'=>$model->id],['data'=>['pjax'=>false],'class'=>"btn btn-success"]);
            if($model->status!=OrdersPayments::STATUS_RECEIVED){
                $statusButtonID=uniqid('statusButton_');
                $this->registerJs('
                $("#'.$statusButtonID.'").click(function(e){
                    e.preventDefault();
                    swal({
                        title: "Подтверждение платежа",
                        text: "Вы действительно хотите подтвердить получение средств?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-info",
                        confirmButtonText: "Да, подтвердить",
                        cancelButtonText: "Отмена",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            $.ajax({url:"'.\yii\helpers\Url::to(['status','id'=>$model->id]).'",success:function(){
                                swal({
                                    title: "Подтверждение",
                                    text: "Платеж подтвержден",
                                    type: "success",
                                    confirmButtonClass: "btn-success"
                                });
                                reload();
                            }})
                        }
                    });
                    
                })
            ',\yii\web\View::POS_END);
                echo Html::a('<i class="icmn-checkmark4" aria-hidden="true"></i>',
                    ['status','id'=>$model->id],[
                        'id'=>$statusButtonID,
                        'class'=>"btn btn-info"
                    ]);
            }
            echo RemoveButton::widget([
                'linkOptions'=>[
                    'text' => '<i class="icmn-bin" aria-hidden="true"></i>',
                    'url' => ['remove','id'=>$model->id],
                    'options' => ['class'=>'btn btn-danger']
                ],
                'ajax'=>true
            ]);
    ?></div>


</td>
