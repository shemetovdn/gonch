<?php
use yii\widgets\Menu;

echo Menu::widget([
    'items'=>[
        ['label'=>'Компания','url'=>['site/index']],
        ['label'=>'Новости','url'=>['news/index']],
        ['label'=>'Доставка и оплата','url'=>['site/dostavka-i-oplata']],
        ['label'=>'Обмен и возврат','url'=>['site/obmen-i-vozvrat']],
        ['label'=>'Оферта','url'=>['site/oferta']],
    ],
    'linkTemplate' => '<a href="{url}">{label}</a>',
]); ?>