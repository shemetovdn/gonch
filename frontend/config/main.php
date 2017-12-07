<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

$config = [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'homeUrl' => '/',
    'controllerNamespace' => 'frontend\controllers',
    'bootstrap' => ['log'], //['assetsAutoCompress']
    'components' => [
        'assetManager' => [
            'bundles' => [
                'dosamigos\google\maps\MapAsset' => [
                    'options' => [
                        'key' => 'AIzaSyDIPaMVi6Ld82YnqZi6PPF1-fdWo-27thc',
                        'language' => 'ru',
//                        'version' => '3.1.18'
                    ]
                ]
            ]
        ],
        'assetsAutoCompress' =>
            [
                'class' => '\skeeks\yii2\assetsAuto\AssetsAutoCompressComponent',
                'cssFileBottom' => true,
                'jsFileCompile' => false,
                'htmlCompress' => true,
                'enabled' => true
            ],
        'i18n' => array(
            'translations' => array(
                'dict*' => array(
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => "@frontend/messages",
                    'sourceLanguage' => 'ru-RU',
                ),
                'map*' => array(
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => "@frontend/messages",
                    'sourceLanguage' => 'ru-RU',
                ),
                'map_eng*' => array(
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => "@frontend/messages",
                    'sourceLanguage' => 'ru-RU',
                ),
                'admin*' => array(
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => "@backend/messages",
                    'sourceLanguage' => 'ru-RU',
                ),

            )
        ),
        'request' => [
            'baseUrl' => '',
            'enableCsrfValidation' => false,
            'class' => 'wbp\lang\LangRequest'
        ],
        'user' => [
            'identityClass' => 'backend\modules\clients\models\Client',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_frontendUser', // unique for frontend
                'path' => '/frontend/web'  // correct path for the frontend app.
            ]
        ],
        'session' => [
            'name' => '_frontendSessionId', // unique for frontend
            'savePath' => __DIR__ . '/../runtime', // a temporary folder on frontend
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'class' => 'wbp\urlManager\UrlManager',
            'ruleConfig' => ['class' => '\wbp\urlManager\UrlRule'],
            'enablePrettyUrl' => true,
            'showScriptName' => false,
//            'suffix' => '/',
            'rules' => [
                'sitemap.xml' => 'site/sitemap-xml',

                '' => 'site/index',
                'main'      => 'site/index',
                'category'   => 'category/index',
                'soc-login' => 'site/soc-login',
                'login' => 'auth/login',
                'logout' => 'auth/logout',
                'signup' => 'auth/signup',
                'cart'      => 'site/cart',
                'company'      => 'site/company',
                'dostavka-i-oplata'      => 'site/dostavka-i-oplata',
                'obmen-i-vozvrat'      => 'site/obmen-i-vozvrat',
                'oferta'      => 'site/oferta',
                'callback' => 'site/callback',
                'subscribe' => 'site/subscribe',
                'checkout' => 'checkout/index',
                'search' => 'site/search',

                'category/<href:[\w\-]+>/<sort:[\w\-]+>' => 'category/index',
                'category/<href:[\w\-]+>' => 'category/index',


                'news' => 'news/index',
                'news/<href:[\w\-]+>' => 'news/view',
                'shares' => 'shares/index',
                'shares/<href:[\w\-]+>' => 'shares/view',
                'discounts' => 'discounts/index',
                'discounts/<href:[\w\-]+>' => 'discounts/view',

                'services'      => 'services/index',
                'services/<href:[\w\-]+>' => 'services/view',

                'product'      => 'product/index',
                'product/<href:[\w\-]+>' => 'product/view',
                'profile/<href:(billing-address|my-account|credit-cards|order-history)>' => 'profile/index',


                '<href:[\w\-]+>' => array(
                    'pattern' => '<href:[\w\-]+>',
                    'route' => 'site/generic-page',
                    'type' => 'db',
                    'fields' => array(
                        'href' => array('table' => 'pages', 'field' => 'href', 'parent_parameter' => 'parent_page'),
                    ),
                ),

                '<action:[\w\-]+>' => 'site/<action>',
                '<controller:[\w\-]+>/<action:[\w\-]+>' => '<controller>/<action>',
            ],
        ],
        'lang' => [
            'class' => 'wbp\lang\Lang',
            'languages' => [
                'ru-RU' => '',
                'ua-UA' => 'ua',
            ],
            'languagesUrls' => [
                'ru-RU' => '',
                'ua-UA' => 'ua',
            ],
        ],
        'formatter' => [
            'locale'=>'ru_RU'
        ],

    ],
    'language' => 'ua-UA',
    'sourceLanguage' => 'ru-RU',
    'params' => $params,
    'aliases' => [
        '@wbp' => '@vendor/wbp',
        '@serverDocumentRoot' => $_SERVER['DOCUMENT_ROOT'],
        '@frontend' => '@serverDocumentRoot' . '/frontend',
    ],
];

if (file_exists(__DIR__ . '/eauth.php')) {
    $eauthConfig = require 'eauth.php';
    $config = \yii\helpers\ArrayHelper::merge($config, $eauthConfig);
    $eauthServices = array_keys($config['components']['eauth']['services']);
}

return $config;
