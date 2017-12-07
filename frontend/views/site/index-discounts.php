<?php
    echo \yii\widgets\ListView::widget([
        'dataProvider'=>$model,
        'options'=>[
            'class'=>'owl-carousel owl-theme owl-carousel-2',
        ],
        'itemOptions'=>[
            'tag'=>'div',
            'class'=>'item',
        ],
        'itemView'=>'index-discounts-item',
        'layout'=>"{items}"
    ])
?>
