<?php

namespace backend\modules\products\models;

use backend\modules\products\models\ObjectTypes;
use common\models\WbpActiveRecord;
use yii\helpers\Url;
use backend\modules\categories\models\Category;
use backend\modules\products\models\Products;
use common\models\User;
use backend\modules\products\models\ProductsParametrs;
use yii;


class Associated extends WbpActiveRecord
{

    public static function tableName()
    {
        return '{{%associated}}';
    }

    public function rules()
    {
        return [
            [[
                'user_id',
                'product_id',
                'associated_id',
            ], 'safe'],
        ];
    }

    public static function addAssociated($product_id, $associated_id)
    {
        $associated = Associated::find()->where(["product_id" => $product_id, "associated_id" => $associated_id])->one();

        if(empty($associated)){

            $associated = new Associated();
            $associated->product_id = $product_id;
            $associated->associated_id = $associated_id;
            if ($associated->save()) {
                return 1;
            } else {
                return 0;
            }

        }

    }


//    public function attributeLabels()
//    {
//        return [
//            'title' => \Yii::t('admin', 'title'),
//        ];
//    }


    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'associated_id']);
    }

}