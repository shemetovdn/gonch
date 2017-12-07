<?php
    echo \yii\widgets\ListView::widget([
        'dataProvider'=>$model,
        'options'=>[
            'class'=>'owl-carousel owl-theme',
        ],
        'itemOptions'=>[
            'tag'=>'div',
            'class'=>'item',
        ],
        'itemView'=>'../site/index-products-slider-item',
        'layout'=>"{items}"
    ])
?>
