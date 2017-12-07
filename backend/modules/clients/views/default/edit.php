<?
use yii\helpers\Html;

$this->title='Edit Client';

    $this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>

<div class="heading-buttons">
    <h3><?=$this->title.' "'.$model->name.'"'?><span> | Clients</span></h3>

    <div class="buttons pull-right">
        <?=Html::a('<i></i>Add new client', ['add'],['class'=>'btn btn-primary btn-icon glyphicons circle_plus '])?>
        <?=\wbp\widgets\RemoveButton::widget([
            'linkOptions'=>[
                'text' => '<i></i>Remove',
                'url' => ['remove','id'=>$model->id],
                'options' => ['class'=>'btn btn-default btn-icon glyphicons bin']
            ],
            'ajax'=>false
        ]);
        ?>
    </div>
    <div class="clearfix"></div>
</div>

<div class="separator bottom"></div>

<div class="innerLR">

    <?=$form?>

</div>
