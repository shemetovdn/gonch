<?
use yii\helpers\Html;
use wbp\widgets\RemoveButton;

$this->registerJs('
    function reload(){
        $.pjax.reload({container:"#listView",history:false});
    }
',\yii\web\View::POS_END,'reloader');

$bg='color: '.\backend\modules\orders\models\Orders::$order_colors[$model->status].';';

?>
<td class="center" style="<?=$bg?>"><?= $model->id ?></td>
<td style="<?=$bg?>"><?= $model->first_name ?> <?= $model->last_name?></td>
<td style="<?=$bg?>"><?= $model->phone?></td>
<td style="<?=$bg?>"><?= $model->comment?></td>
<td class="center" style="<?=$bg?>"><?=\backend\modules\orders\models\Orders::$order_statuses[$model->status]?></td>
<td style="<?=$bg?>"><?= $model->total?></td>
<? if(Yii::$app->user->identity->role==2){ ?>
    <td style="<?=$bg?>"><?= $model->paid?></td>
    <td style="<?=$bg?>"><?= $model->balance?></td>
<? } ?>
<td class="center" style="<?=$bg?>"><?= $model->created_at?></td>
<td class="center" style="<?=$bg?>width:120px;">
    <div class="btn-group btn-actions" aria-label="" role="group"><?
        echo Html::a('<i class="icmn-pencil" aria-hidden="true"></i>',['edit','id'=>$model->id],['data'=>['pjax'=>false],'class'=>"btn btn-success"]);
        if(
            (
                ($model->status==\backend\modules\orders\models\Orders::STATUS_CREATED && $model->getPaid(false)>0) ||
                ($model->getBalance(false)>=0 && $model->status==\backend\modules\orders\models\Orders::STATUS_PREPAYMENT_CONFIRMATION)
            ) &&
            (Yii::$app->user->identity->role==2 || Yii::$app->user->identity->role==10)
        ){
            $statusButtonID=uniqid('statusButton_');
            $this->registerJs('
                $("#'.$statusButtonID.'").click(function(e){
                    e.preventDefault();
                    swal({
                        title: "Подтверждение оплаты",
                        text: "Вы действительно хотите подтвердить оплату/предоплату заказа?",
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
                                    text: "Оплата/Предоплата подтверждена",
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
