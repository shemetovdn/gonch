<?php
use yii\widgets\Menu;
?>


<?= Menu::widget([
    'items'=>
        \frontend\helpers\CategoryMenu::getSubmenuItems(),
    'submenuTemplate' => "\n<ul class='dropdown-menu collapse custom-1'>\n{items}\n</ul>\n",
    'options'=>[
        'class'=>'nav navbar-nav',
    ],
    'linkTemplate' => '<a href="{url}">{label}</a>',
]); ?>
