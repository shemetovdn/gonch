<?php
    echo \yii\widgets\ListView::widget([
        'dataProvider'=>$news,
        'options'=>[
            'class'=>'row',
        ],
        'itemOptions'=>[
            'tag'=>'div',
            'class'=>'col-md-4 col-sm-6',
            'data-hide'=>'true',
        ],
        'itemView'=>'index-news-item',
        'layout'=>"{items}"
    ])
?>
