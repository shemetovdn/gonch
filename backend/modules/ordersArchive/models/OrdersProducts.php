<?php
namespace backend\modules\ordersArchive\models;

use backend\modules\filter\models\ParametrsValue;
use backend\modules\products\models\Products;
use backend\modules\stock\models\Stock;
use common\models\WbpActiveRecord;

class OrdersProducts extends WbpActiveRecord
{
    public static function tableName()
    {
        return '{{%orders_products}}';
    }

    public function getProduct(){
        return $this->hasOne(Products::className(),['id'=>'product_id']);
    }

    public function getSize(){
        return $this->hasOne(ParametrsValue::className(),['id'=>'size_id']);
    }

    public function getOrder(){
        return $this->hasOne(Orders::className(),['id'=>'order_id']);
    }

    public function getReservations(){
        return $this->hasMany(Stock::className(),['reserve_id'=>'id'])->andWhere(['status'=>Stock::STATUS_RESERVED]);
    }

    public function isReserved(){
        $current_stock=$this->getReservations()->select("count(*) as qty")->orderBy('id')->one();
        if($current_stock->qty==$this->qty) return true;
        else return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
//        $this->unreserve();
//
//        $this->reserve();

        return parent::afterSave($insert, $changedAttributes);
    }

    public function reserve(){
        for($i=0;$i<$this->qty;$i++){
            $stock=Stock::find()->where(['product_id'=>$this->product_id,'size_id'=>$this->size_id])->andWhere(['status'=>Stock::STATUS_AVAILABLE])->orderBy('id')->one();
            if($stock){
                $stock->status=Stock::STATUS_RESERVED;
                $stock->reserve_id=$this->id;
                $stock->save();
            }
        }
    }

    public function unreserve(){
        $current_stock=$this->getReservations()->orderBy('id')->all();
        foreach ($current_stock as $stock){
            $stock->reserve_id=0;
            $stock->status=Stock::STATUS_AVAILABLE;
            $stock->save();
        }
    }

}
