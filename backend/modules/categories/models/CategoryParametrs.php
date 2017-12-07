<?php
namespace backend\modules\categories\models;

use backend\modules\products\models\ProductsParametrs;
use common\models\WbpActiveRecord;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\modules\parametrs\models\Parametrs;
use creocoder\nestedsets\NestedSetsBehavior;

class CategoryParametrs extends WbpActiveRecord
{
    public static function tableName()
    {
        return '{{%category_parameters}}';
    }

    public function rules()
    {
        return [
            [['title',
                'category_id',
                'parametr_id'
            ], 'safe'],
        ];
    }

    public function getParametr(){
        return $this->hasOne(Parametrs::className(), ['id' => 'parametr_id']);
    }
    public function getProdParam($id){
        return ProductsParametrs::find()->where(['product_id'=>$id, 'parametr_id'=>$this->parametr_id])->one();
    }
}