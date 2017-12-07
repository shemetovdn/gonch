<?php
    echo \yii\widgets\ListView::widget([
        'dataProvider'=>$model,
        'options'=>[
            'class'=>'row someproduct',
        ],
        'itemOptions'=>[
            'tag'=>'div',
            'class'=>'col-md-4 col-sm-6 colum',
        ],
        'itemView'=>'../site/index-category-item',
        'layout'=>"{items}"
    ])
?>
