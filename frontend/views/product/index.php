<?php
/**
 * Created by PhpStorm.
 ** User: TrickTrick alexeymarkov.x7@gmail.com
 *** Date: 27-Mar-17
 **** Time: 14:26
 */
$bundle = \frontend\assets\AppAsset::register($this);
$this->registerJs("
    $('li.dropdown').addClass('active');
");

$this->registerCss("
    .text-center li {
        display: inline-block;
    }
");
?>
<section>
    <div class="container custcontact">
        <h1 class="text-center"><?= Yii::t("app", "Our Products")?></h1>
    </div>
</section>
<section>
    <div class="silver-bg padingpart-2">
        <div class="container">
            <?= \yii\widgets\Menu::widget([
                'items' => $middleMenuItems,
                'options' => [
                    'class' => 'text-center',
                ],
                'linkTemplate' => '<a href="{url}" class="head-bt-4 wert">{label}</a>',
            ])?>

            <div class="clearfix"></div>

            <?
            echo \yii\widgets\ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => 'item-product',
                'summary' => false,
            ]);
            ?>
            <div class="clearfix"></div>
        </div>
    </div>
</section>
