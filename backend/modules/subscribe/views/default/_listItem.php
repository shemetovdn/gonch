<?
use wbp\widgets\RemoveButton;
use yii\helpers\Html;

$color = 'green';
if($model->status == 0) $color = '#D05454';
?>


<td class="center" style="color: <?= $color ?>"><?= $model->id ?></td>
<td class="center" style="color: <?= $color ?>"><?= Html::encode($model->email) ?></td>
<td class="center" style="color: <?= $color ?>"><?= Yii::$app->formatter->asDatetime($model->created_at) ?></td>
<td class="center">
    <div class="btn-group btn-actions" aria-label="" role="group" style="">
<!--        <a href="--><?//=\yii\helpers\Url::to(['edit','id'=>$model->id])?><!--" class="btn btn-success">-->
<!--            <i class="icmn-pencil" aria-hidden="true"></i>-->
<!--        </a>-->
        <?=RemoveButton::widget([
            'linkOptions'=>[
                'text' => '<i class="icmn-bin" aria-hidden="true"></i>',
                'url' => ['remove','id'=>$model->id],
                'options' => ['class'=>'btn btn-danger']
            ],
            'ajax'=>true
        ]);
        ?>
    </div>
</td>
