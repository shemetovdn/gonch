<?php

use backend\modules\management\models\Management;
use yii\widgets\Menu;
use yii\helpers\Url;

$bundle = \frontend\assets\ImageAsset::register($this);

use \frontend\widgets\SvgWidget\SvgWidget;

?>
    <!--container end-->

        <div class="dev-space-to-footer"></div>
    </div>
    </div>
    </div>
    <footer>

        <div class="top-footer">
            <div class="container">
                <div class="col-sm-9 col-sm-offset-3">
                    <?= $this->render('subscribe', ['formModel' => Yii::$app->controller->modelSubscribe]); ?>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="col-sm-9 col-sm-offset-3">
                <div class="row">
                    <div class="col-sm-4 col-md-3">
                        <div class="title-ft">Каталог</div>
                        <?= Menu::widget([
                            'items' =>
                                \backend\modules\categories\models\Category::getParentCategoryForMenu()
                            ,
                            'options' => [
                                'class' => 'footer-links',
                            ],
                            'linkTemplate' => '<a href="{url}">{label}</a>',
                        ]); ?>
                    </div>
                    <!-- -->
                    <div class="col-sm-4 col-md-3">
                        <div class="title-ft">Gonchar House</div>

                        <?= Menu::widget([
                            'items' => [
                                ['label' => \Yii::t('app', 'Компания'), 'url' => ['site/index']],
                                ['label' => \Yii::t('app', 'Новости'), 'url' => ['news/index']],
                                ['label' => \Yii::t('app', 'Доставка и оплата'), 'url' => ['site/dostavka-i-oplata']],
                                ['label' => \Yii::t('app', 'Обмен и возврат'), 'url' => ['site/obmen-i-vozvrat']],
                                ['label' => 'Оферта', 'url' => ['site/oferta']],
                            ],
                            'options' => [
                                'class' => 'footer-links',
                            ],
                            'linkTemplate' => '<a href="{url}">{label}</a>',
                        ]); ?>
                    </div>
                    <!-- -->
                    <div class="col-sm-4 col-md-3">
                        <div class="title-ft"><?= \Yii::t('app', 'Контакты'); ?></div>
                        <ul class="footer-links">
                            <li>
                                <a href="tel:<?php echo preg_replace('~[^0-9]+~', '', \common\models\Config::getParameter('phone')); ?>"><?= \common\models\Config::getParameter('phone') ?></a>
                            </li>
                            <li>
                                <a href="tel:<?php echo preg_replace('~[^0-9]+~', '', \common\models\Config::getParameter('phone_2')); ?>"><?= \common\models\Config::getParameter('phone_2') ?></a>
                            </li>
                            <li>
                                <a href="tel:<?php echo preg_replace('~[^0-9]+~', '', \common\models\Config::getParameter('phone_3')); ?>"><?= \common\models\Config::getParameter('phone_3') ?></a>
                            </li>
                            <li><a href="#"></a></li>
                            <li><a style="margin-right: -29px; display: inline-block;"
                                   href="mailto:<?= \common\models\Config::getParameter('email') ?>"><?= \common\models\Config::getParameter('email') ?></a>
                            </li>
                        </ul>
                        <div class="hidden-md visible-sm hidden-xs hidden-lg">
                            <div class="title-ft"><?= \Yii::t('app', 'Личный кабинет'); ?></div>
                            <ul class="footer-links">
                                <li>
                                    <?php if (!empty(Yii::$app->user->id)) { ?>
                                        <a href="<?php echo Url::to('/auth/logout') ?>"><?= \Yii::t('app', 'Выйти'); ?></a>
                                    <?php } else { ?>
                                        <a data-dialog="somedialog"><?= \Yii::t('app', 'Войти'); ?></a> / <a
                                                data-dialog="somedialog-2"><?= \Yii::t('app', 'Регистрация'); ?></a>
                                    <?php } ?>


                                </li>
                                <li>
                                    <a href="<?php echo Url::to('/site/cart') ?>"><?= \Yii::t('app', 'Моя корзина'); ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- -->
                    <div class="col-md-3 hidden-sm col-xs-12">
                        <div class="title-ft"><?= \Yii::t('app', 'Личный кабинет'); ?></div>
                        <ul class="footer-links">
                            <li>
                                <?php if (!empty(Yii::$app->user->id)) { ?>
                                    <a href="<?php echo Url::to('/auth/logout') ?>"><?= \Yii::t('app', 'Выйти'); ?></a>
                                <?php } else { ?>
                                    <a data-dialog="somedialog"><?= \Yii::t('app', 'Войти'); ?></a> / <a
                                            data-dialog="somedialog-2"><?= \Yii::t('app', 'Регистрация'); ?></a>
                                <?php } ?>


                            </li>
                            <li><a href="<?php echo Url::to('/site/cart') ?>"><?= \Yii::t('app', 'Моя корзина'); ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="black-line-footer">
            <div class="container">
                <div class="col-sm-9 col-sm-offset-3">
                    <div class="row">
                        <div class="col-md-6 col-xs-12 col-sm-12">
                            <div class="copy">© 2017 Gonchar
                                House______ <?= \Yii::t('app', 'Все права защищены'); ?></div>
                        </div>
                        <div class="col-md-6 col-xs-12 development-text-align">
                            <span class="proect">
                                <?= \Yii::t('app', 'Разработка'); ?> –
                                <a href="<?= Url::to('http://www.studiomarka.com/') ?>.">Marka</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
<?php
Url::remember();
?>
<?= \frontend\widgets\callbackWidget\CallbackWidget::widget() ?>
<?= $this->render('sign_popup', ['registerForm' => Yii::$app->controller->registerForm]) ?>
<?= $this->render('login_popup.php', ['loginFormModel' => Yii::$app->controller->loginFormModel]) ?>
<?= $this->render('success_wishlist_add') ?>
<?= $this->render('addToCart_popup') ?>
<?= $this->render('availability_popup') ?>
<?php
$session = Yii::$app->session;
if (!$session->isActive) {
    $session->open();
}
if ($session->get('register')) {
    $session->remove('register');
    ?>

    <?= $this->render('register_success_popup') ?>

<?php } ?>
<?php
$this->registerJs("

        var dlgtrigger = document.querySelectorAll( '[data-dialog]' );
        
            for(var i = 0; i < dlgtrigger.length; i++){
            
               var somedialog = document.getElementById( dlgtrigger[i].getAttribute( 'data-dialog' ) );
               var dlg = new DialogFx( somedialog );

        dlgtrigger[i].addEventListener( 'click', dlg.toggle.bind(dlg) );
            }



        var owl2 = $('.owl-carousel-2');
        owl2.owlCarousel({
            margin: 0,
            loop: false,
            items: 1,
            dots: true,
            navText: [ '', '' ],
            nav: true,
            responsiveClass:true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                1000:{
                    items:1
                }
            }
        })
        
          var owl3 = $('.owl-carousel-3');
        owl3.owlCarousel({
            margin: 0,
            loop: false,
            items: 1,
            dots: true,
            navText: [ '', '' ],
            nav: true,
            responsiveClass:true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                1000:{
                    items:1
                }
            }
        })      
", yii\web\View::POS_LOAD);
?>