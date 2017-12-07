<?
$bundle = \frontend\assets\AppAsset::register($this);

$this->registerJs('

', yii\web\View::POS_READY);

echo \yii\widgets\ListView::widget([
    'dataProvider'=>$dataProvider,
    'options'=>[
        'class'=>'row someproduct',
    ],
    'itemOptions'=>[
        'tag'=>'div',
        'class'=>'col-md-4 col-sm-6 colum',
    ],
    'itemView'=>'wishes-item',
    'layout'=>"{items}"
])
?>