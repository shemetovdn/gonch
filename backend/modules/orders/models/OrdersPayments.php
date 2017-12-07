<?php
namespace backend\modules\orders\models;

use backend\modules\filter\models\ParametrsValue;
use backend\modules\products\models\Products;
use common\models\WbpActiveRecord;

class OrdersPayments extends WbpActiveRecord
{
    const STATUS_AWAITING=0;
    const STATUS_RECEIVED=1;
    public static $imageTypes=['OrdersPayments'];
    public static $paymentTypes=['Liqpay', 'Наложенный платеж'];
    public $client_id;

    public static function tableName()
    {
        return '{{%orders_payments}}';
    }

    public function rules()
    {
        return [
            [['order_id','payment_type','status','comment','amount','real_amount','date',
                'time','transaction_id','country_id','phone','method'],'safe','on'=>[self::ADMIN_EDIT_SCENARIO, self::ADMIN_ADD_SCENARIO]]
        ];
    }

    public static function getManualPaymentTypes(){
        $pt=self::$paymentTypes;
        unset($pt[3]);
        return $pt;
    }

    public function getOrder(){
        return $this->hasOne(Orders::className(),['id'=>'order_id']);
    }

    public function getCurrency(){
        return $this->order->currency;
    }

    public function beforeSave($insert)
    {
//        if($this->order->client_id) $this->client_id=$this->order->client_id;
//        if($this->order->currency_id) $this->currency_id=$this->order->currency_id;
        return parent::beforeSave($insert);
    }

    public function attributeLabels()
    {
        return [
            'order_id'=>'Номер заказа',
            'transaction_id'=>'Номер платежа',
            'payment_type'=>'Тип платежа',
            'status'=>'Средства на счету, полученны',
            'comment'=>'Коментарий',
            'amount'=>'Сумма (план.)',
            'real_amount'=>'Сумма (факт.)',
            'date'=>'Дата оплаты, время',
            'time'=>'Время оплаты',
            'country_id'=>'Страна',
            'phone'=>'Телефон',
            'method'=>'Метод Оплаты',
        ];
    }

}
