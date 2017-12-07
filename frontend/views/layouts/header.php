<?php

use yii\widgets\ActiveForm;
use yii\widgets\Menu;
use yii\helpers\Url;
$bundle = \frontend\assets\ImageAsset::register($this);
use \frontend\widgets\SvgWidget\SvgWidget;
use \frontend\widgets\searchWidget\SearchWidget;
$session = Yii::$app->session;
if(!$session->isActive){$session->open();}
?>

<div class="maintemplate">
    <div class="container">

        <div class="row dev-row">

        <div class="site-maska"></div>

        <div class="col-sm-3 castommobile">
            <div class="bgmenu">
                <div class="linemenu">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                                aria-expanded="false" aria-controls="navbar">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div id="navbar" class="collapse navbar-collapse">
                        <a href="<?php echo Url::to(["/site"]);?>" class="logo"><?=SvgWidget::getSvgIcon('logo')?></a>
                        <div class="clearfix"></div>
                        <?=$this->render('category_menu')?>

                        <div class="dev-lines"></div>

                        <ul class="dev-menu">

                            <li <? if(Yii::$app->controller->id=='shares') echo 'class="active"';?>>
                                <a href="<?=Url::to("/shares")?>">
                                    <span class="icon_cat" style="background-image: url('<?=$bundle->baseUrl?>/images/shares.png');"></span>
                                    <?php echo \Yii::t("app",'Акции')?>
                                </a>
                            </li>
                            <li <? if(Yii::$app->controller->id=='discounts') echo 'class="active"';?>>
                                <a href="<?=Url::to("/discounts")?>">
                                    <span class="icon_cat" style="background-image: url('<?=$bundle->baseUrl?>/images/discounts.png');"></span>
                                    <?php echo \Yii::t("app",'Скидки')?>

                                </a>
                            </li>
                        </ul>

                        <div class="clearfix"></div>
                        <div class="dev-lines"></div>
<!--                        <div class="line part-2"></div>-->
                        <div class="block-formobile">
                            <?=$this->render('mobile-menu')?>

                            <div class="blue">
                                <a href="<?=Url::to(['/profile/wishes'])?>" class="icones <? if(!Yii::$app->user->id){ echo "wishes";}?> <? if(Yii::$app->controller->route == 'profile/wihes') echo 'active'?>"><?=SvgWidget::getSvgIcon('ifo-16')?></a>
                                <a style="position: relative" href="<?php echo Url::to(['/site/cart']);?>" class="<?php if(count($session->get('cart')) != 0){echo "hover";}?>icones <? if(Yii::$app->controller->route == 'site/cart') echo 'active'?>"><?=SvgWidget::getSvgIcon('ifo-18')?>
                                    <?php if(count($session->get('cart')) != 0 && \Yii::$app->controller->action->id != 'cart'){
                                        echo '<span class="cart_count">'.count($session->get('cart')).'</span>';
                                    }?>
                                </a>
                                <a href="#" class="icones"><?=SvgWidget::getSvgIcon('ifo-12')?></a>
                                <a href="<?php echo Yii::$app->lang->getLanguageUrl("ua-UA");?>" class="lang <? if(Yii::$app->language == 'ua-UA') echo 'active'?>">Ua</a>
                                <a href="<?php echo Yii::$app->lang->getLanguageUrl("ru-RU");?>" class="lang <? if(Yii::$app->language == 'ru-RU') echo 'active'?>">Ru</a>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <a href="#" class="call"  data-dialog="callback_modal"><?=SvgWidget::getSvgIcon('ifo-15')?><?php echo \Yii::t("app", 'Заказать звонок')?></a>
                        <div class="block-blue">
                            <a href="tel:<?php echo preg_replace('~[^0-9]+~','',\common\models\Config::getParameter('phone'));?>" class="call"><?=SvgWidget::getSvgIcon('ifo-10')?><?= \common\models\Config::getParameter('phone')?></a>
                            <div class="hr">
                                <a href="<?= \common\models\Config::getParameter('facebook')?>"><img src="<?=$bundle->baseUrl?>/images/img-6.png" alt="" /></a>
                            </div>
                            <div class="hr">
                                <a href="<?= \common\models\Config::getParameter('google_plus')?>"><img src="<?=$bundle->baseUrl?>/images/img-7.png" alt="" /></a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!--container -->
        <div class="col-sm-9">

            <div class="header-blue-line">

                <a href="<?=Url::to("/site/index")?>" class="logo-mobi"><?=SvgWidget::getSvgIcon('logo-1')?></a>

                <?=SearchWidget::widget()?>

                <?=$this->render('menu')?>

                <div class="someicons">

                    <a href="<?=Url::to(['/profile/wishes'])?>" class="icones <? if(!Yii::$app->user->id){ echo "wishes";}?> <? if(Yii::$app->controller->route == 'profile/wihes') echo 'active'?>"><?=SvgWidget::getSvgIcon('ifo-16')?></a>

                    <a style="position: relative" href="<?php echo Url::to(['site/cart']);?>" class="<?php if(count($session->get('cart')) != 0){echo "hover";}?> icones <? if(Yii::$app->controller->route == 'site/cart') echo 'active'?>"><?=SvgWidget::getSvgIcon('ifo-18')?>
                        <?php if(count($session->get('cart')) != 0){
                            echo '<span class="cart_count">'.count($session->get('cart')).'</span>';
                        }?>
                    </a>
                    <a href="<?=Url::to(['profile/index'])?>" class="icones <? if(!Yii::$app->user->id){ echo "proile";}?> <? if(Yii::$app->controller->route == 'profile/index') echo 'active'?>"><?=SvgWidget::getSvgIcon('ifo-12')?></a>
                    <a href="<?php echo Yii::$app->lang->getLanguageUrl("ua-UA");?>" class="lang <? if(Yii::$app->language == 'ua-UA') echo 'active'?>">Ua</a>
                    <a href="<?php echo Yii::$app->lang->getLanguageUrl("ru-RU");?>" class="lang <? if(Yii::$app->language == 'ru-RU') echo 'active'?>">Ru</a>
                    <div class="clearfix"></div>
                </div>

            </div>


            <div class="some-cast-marg"></div>
