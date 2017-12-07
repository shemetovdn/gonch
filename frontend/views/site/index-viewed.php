<?php
    echo \yii\widgets\ListView::widget([
        'dataProvider'=>$model,
        'options'=>[
            'class'=>'owl-carousel owl-theme',
            'id'=>'index-3',
        ],
        'itemOptions'=>[
            'tag'=>'div',
            'class'=>'item',
        ],
        'itemView'=>'index-products-slider-item',
        'layout'=>"{items}"
    ])
?>
