<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\modules\management\models\Management;
use frontend\widgets\callbackWidget\CallbackWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use \frontend\widgets\SvgWidget\SvgWidget;

$session = Yii::$app->session;
$bundle = \frontend\assets\AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <link rel="shortcut icon" href="<?=$bundle->baseUrl?>/images/favicon.ico">
    <link rel="icon" href="<?=$bundle->baseUrl?>/images/favicon.ico">
    <style>

        select.multi-select{
            display: none;
        }
    </style>
    <?php $this->head() ?>
</head>
<body>

<?= \wbp\PrettyAlert\Alert::widget(["autoSearchInSession" => true]);?>

<?php $this->beginBody() ?>

<div class="maintemplate">
    <div class="container">
        <!--container -->
        <div class="col-sm-12 checkoutstyle">
            <a href="<?=Url::to("site/index")?>" class="logo-mobi visible"><?=SvgWidget::getSvgIcon('logo-1')?></a>

            <div class="someicons">
                <a href="<?=Url::to(['profile/index'])?>" class="icones <? if(!Yii::$app->user->id){ echo "proile";}?> <? if(Yii::$app->controller->route == 'profile/index') echo 'active'?>"><?=SvgWidget::getSvgIcon('ifo-12')?></a>
                <a href="<?php echo Yii::$app->lang->getLanguageUrl("ua-UA");?>" class="lang <? if(Yii::$app->language == 'ua-UA') echo 'active'?>">Ua</a>
                <a href="<?php echo Yii::$app->lang->getLanguageUrl("ru-RU");?>" class="lang <? if(Yii::$app->language == 'ru-RU') echo 'active'?>">Ru</a>
                <div class="clearfix"></div>
            </div>
            <div class="some-cast-marg"></div>

<?=$content?>
<?=$this->render('footer.php')?>
<?php
    Url::remember();
?>

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
