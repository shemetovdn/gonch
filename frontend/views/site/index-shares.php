<?php
    echo \yii\widgets\ListView::widget([
        'dataProvider'=>$model,
        'options'=>[
            'class'=>'owl-carousel owl-theme owl-carousel-3',
        ],
        'itemOptions'=>[
            'tag'=>'div',
            'class'=>'item',
        ],
        'itemView'=>'index-shares-item',
        'layout'=>"{items}"
    ])
?>
