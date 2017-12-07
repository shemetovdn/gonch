<?php

namespace backend\modules\products\models;

use backend\modules\products\models\ObjectTypes;
use common\models\WbpActiveRecord;
use yii\helpers\Url;
use backend\modules\categories\models\Category;
use common\models\User;
use backend\modules\products\models\ProductsParametrs;
use backend\modules\products\models\Associated;
use yii;


class Products extends WbpActiveRecord
{
    public $cat_fore_params;
    public static $seoKey = 'products';
    public static $imageTypes = ['products'];
    public $pricesArray=[];
    public $associated_id;
    public $associated;

    public static function tableName()
    {
        return '{{%products}}';
    }

    public function rules()
    {
        return [
            [[
                'title',
                'title_ua',
                'description',
                'description_ua',
                'href',
                'status',
                'category_id',
                'user_id',
                'price',
                'date',
                'reserve',
                'note',
                'artikul',
                'availability',
                'in_home',
                'recommended',
                'recommended_home',
                'sale',
                'discount_id',
                'old_price'

            ], 'safe', 'on' => [self::ADMIN_ADD_SCENARIO, self::ADMIN_EDIT_SCENARIO]],
            [['title', 'status', 'title_ua' ], 'required', 'message' => 'Это обязательное поле', 'on' => [WbpActiveRecord::ADMIN_ADD_SCENARIO, WbpActiveRecord::ADMIN_EDIT_SCENARIO]],
            [['price'], 'integer', 'message' => 'Введите число'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'title' => \Yii::t('admin', 'title'),
            'title_ru' => \Yii::t('admin', 'title'),
            'href' => \Yii::t('admin', 'href'),
            'description' => \Yii::t('admin', 'description'),
            'description_ru' => \Yii::t('admin', 'description'),
            'status' => \Yii::t('admin', 'status'),
            'parent' => \Yii::t('admin', 'parent'),
            'moisture' => \Yii::t('admin', 'moisture'),
            'moisture_ru' => \Yii::t('admin', 'moisture'),
            'purity' => \Yii::t('admin', 'purity'),
            'purity_ru' => \Yii::t('admin', 'purity'),
            'test_weight' => \Yii::t('admin', 'test_weight'),
            'test_weight_ru' => \Yii::t('admin', 'test_weight'),
            'grain_admixture' => \Yii::t('admin', 'grain_admixture'),
            'grain_admixture_ru' => \Yii::t('admin', 'grain_admixture'),
            'min_order' => \Yii::t('admin', 'min_order'),
            'min_order_ru' => \Yii::t('admin', 'min_order'),
            'packing' => \Yii::t('admin', 'packing'),
            'floor' => \Yii::t('admin', 'Этаж'),
            'total_floor' => \Yii::t('admin', 'Всего этажей'),
            'category_id' => \Yii::t('admin', 'Category'),
            'building_type_id' => \Yii::t('admin', 'Тип здания'),
            'nearness_id' => \Yii::t('admin', 'Близость к морю'),
            'repairs' => \Yii::t('admin', 'Ремонт'),
            'city_id' => \Yii::t('admin', 'Город'),
            'address' => \Yii::t('admin', 'Улица'),
            'object_type_id' => \Yii::t('admin', 'Тип Объекта'),
            'price' => \Yii::t('admin', 'Цена'),
            'price_dollar' => \Yii::t('admin', 'Цена (в долларах)'),
            'old_price' => \Yii::t('admin', 'Старая цена'),

        ];
    }

    public function getCurrent_price(){
        if(!empty($this->new_price)){
            return $this->new_price;}
        else{ return $this->price;}
    }

    public function getDiscountRate(){
        if(!empty($this->old_price)){
            return round(100 - $this->price*100/$this->old_price);
        }
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }


    public function getUrl($absolute = false)
    {
        return Url::to(['product/'.$this->href], $absolute);
    }

    public function hasChildren()
    {
        return $this->getChildren()->count();
    }

    public function getChildren()
    {
        return self::find()->where(['status' => 1, 'parent' => $this->id])->orderBy(['sort' => SORT_ASC]);
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getParams(){

        $params = ProductsParametrs::find()->where(['product_id'=>$this->id])->all();
$arrayPar = [];

        foreach($params as $key =>$value){
            $arrayPar[$value["parametr_id"]]['value'] = $value["value"];
            $arrayPar[$value["parametr_id"]]['value_ua'] = $value["value_ua"];
        }
        return $arrayPar;
    }
//    public function getParametrs(){
//        return $this->hasMany(ProductsParametrs::className(), ['product_id' => 'id'])->orderBy('sort');
//    }
    public function getParametrs(){
        return $this->category->parametrs;
    }
    public function getAssociatedProducts(){
        return $this->hasMany(Associated::className(), ['product_id' => 'id'])
            ;
    }

    public function getProductParametrs(){
        return $this->category->categoryParametrs;
}

    public function getParametr($id){
        $param_value ='';
        $param = ProductsParametrs::find()->where(['advert_id'=>$this->id, 'parametr_id' => $id])->asArray()->one();
        if($param){
            if($param['field_type_id'] == 3){
                $param_value = $param['value'];
            }elseif($param['field_type_id'] == 1){
                $param_value = \backend\modules\parametrs\models\ParametrsValue::findOne($param['value_id'])->value;
            }elseif($param['field_type_id'] == 2){
                $ids = explode(',', $param['value']);
                $parametrs = \backend\modules\parametrs\models\ParametrsValue::find()->where(['id' => $ids])->all();
                $param_value = array();
                foreach($parametrs as $key => $value){
                    $param_value[] = $value->value;
                }
            }
        }
        return $param_value;
    }


    public function afterSave($insert, $changedAttributes)
    {
        $parametrs = Yii::$app->request->post("Products")["parametrs"];
        $associated = Yii::$app->request->post("Products")["associated"];
//        echo "<pre>";var_dump($parametrs);exit;
        $param_del = ProductsParametrs::find()->where(['product_id'=>$this->id])->all();
        foreach($param_del as $param){
            $param->delete();
        }

        if(isset($parametrs)&&is_array($parametrs)){
            $sort = 0;
            foreach($parametrs as $key =>$value){

                foreach ($value as $param_id =>$param_value){

                    $param = new ProductsParametrs();
                    $param->product_id = $this->id;
                    $param->parametr_id = $param_id;
                    $param->field_type_id = $key;
                    $param->sort = $param_value["sort"];
                    if(is_array($param_value["value"])){
                        $param_value["value"] = implode(',',$param_value["value"]);
                        $param->value = $param_value["value"];
                    }elseif ($key == 3&& $param_value["value"]!= ''){
                        $param->value = $param_value["value"];
                    }elseif($key == 1){
                        $param->value_id = $param_value["value"];
                    }
                    $param->value = $param_value["value"];
                    $param->value_ua = $param_value["value_ua"];
                    $param->sort = $param_value["sort"];

                    $param->save();
                    $sort++;
                }
            }
        }

        if(isset($associated)&&is_array($associated)){
            foreach($associated as $key => $value){
//                echo "<pre>";var_dump($value);exit;

                $product = Associated::find()->where(["associated_id" => $value, "product_id" => $this->id])->one();
                if(empty($product)){
                    $product = new Associated();
                    $product->product_id = $this->id;
                    $product->associated_id = $value;
                    $product->save();
                }
            }
        }

        return parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

}