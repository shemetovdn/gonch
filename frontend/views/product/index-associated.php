<?php
    echo \yii\widgets\ListView::widget([
        'dataProvider'=>$model,
        'options'=>[
            'id' => 'owl_assoc',
            'class'=>'owl-theme',
        ],
        'itemOptions'=>[
            'tag'=>'div',
            'class'=>'item',
        ],
        'itemView'=>'../site/index-products-slider-item',
        'layout'=>"{items}"
    ])
?>
