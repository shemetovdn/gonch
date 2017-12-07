<?php

namespace frontend\helpers;
use Yii;
use yii\helpers\Url;
use yii\web\Request;

/**
 * Created by PhpStorm.
 ** User: TrickTrick alexeymarkov.x7@gmail.com
 *** Date: 27-Mar-17
 **** Time: 14:47
 */
class CategoryMenu
{
    public static function getItems()
    {
        $categories = \backend\modules\categories\models\Category::find()->where(['status' => 1])->all();
        $result = [];
        foreach ($categories as $category) {
            $result[] = [
                    'label' => \Yii::t('app', $category->title),
                    'url' => $category->link
                ];
        }
        return $result;

    }

    public static function getSubmenuItems()
    {
        $categories = \backend\modules\categories\models\Category::getCategoryForMenu();
        $result = [];
        foreach ($categories as $key => $category) {
            if(empty($category['items'])){
                $category['items'] = array();
            }
            $result[] = [
                'label' => \Yii::t('app', $category['title']),
                'url' => $category['url'],
                'items'=>$category['items'],
                'template' => '<a class="dropdown-toggle" data-toggle="dropdown" href="{url}" role="button" aria-haspopup="true" >
                                '.$category['icon'].'
                                {label}<span class="carett"></span>
                               </a>',
                'options' => [
                    'class'=>'dropdown dropdown1',
                ],
            ];
        }

        return $result;

    }



}