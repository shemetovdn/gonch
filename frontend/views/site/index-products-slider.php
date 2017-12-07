<?php
    echo \yii\widgets\ListView::widget([
        'dataProvider'=>$model,
        'options'=>[
            'class'=>'owl-carousel owl-theme',
            'id'=>'index-1'
        ],
        'itemOptions'=>[
            'tag'=>'div',
            'class'=>'item',
            'data-hide'=>'true',
        ],
        'itemView'=>'index-products-slider-item',
        'layout'=>"{items}"
    ])
?>
