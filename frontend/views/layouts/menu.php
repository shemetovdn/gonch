<?php
use yii\widgets\Menu;

echo Menu::widget([
    'items'=>[
        ['label'=>\Yii::t('app', 'Компания'),'url'=>['site/company']],
        ['label'=>\Yii::t('app', 'Новости'),'url'=>['news/index']],
        ['label'=>\Yii::t('app', 'Доставка и оплата'),'url'=>['site/dostavka-i-oplata']],
        ['label'=>\Yii::t('app', 'Обмен и возврат'),'url'=>['site/obmen-i-vozvrat']],
        ['label'=>'Оферта','url'=>['site/oferta']],
    ],
    'options' => [
        'class' =>"menu-2 hidden-sm",
    ],
    'linkTemplate' => '<a href="{url}">{label}</a>',
]); ?>