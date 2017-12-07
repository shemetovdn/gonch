<?php

namespace backend\modules\products\models;

use backend\modules\categories\models\Category;
use common\models\WbpActiveRecord;
use yii\helpers\Url;
use backend\modules\parametrs\models\ParametrsValue;
use backend\modules\parametrs\models\Parametrs;


class ProductsParametrs extends WbpActiveRecord
{

    public static $seoKey = 'adverts';
    public static $imageTypes = ['adverts'];

    public static function tableName()
    {
        return '{{%products_parametrs}}';
    }
    public function getParametrValue()
    {
        return $this->hasOne(ParametrsValue::className(), ['id' => 'value_id']);
    }

    public function getParam()
    {
        return $this->hasOne(Parametrs::className(), ['id' => 'parametr_id']);
    }
    public function getVal()
    {
        if($this->field_type_id == 3){
            return $this->getMultiLang('value');
        }elseif($this->field_type_id == 1 && $this->parametrValue){
            return $this->parametrValue->getMultiLang('value');
        }

    }

}