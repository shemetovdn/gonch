<?php
    echo \yii\widgets\ListView::widget([
        'dataProvider'=>$model,
        'options'=>[
            'class'=>'row someproduct product-lister-outer',
        ],
        'itemOptions'=>[
            'tag'=>'div',
            'class'=>'thisblock whith-desc-list',
        ],
        'itemView'=>'index-category-item',
        'layout'=>"{items}"
    ])
?>
