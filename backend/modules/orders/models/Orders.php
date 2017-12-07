<?php
namespace backend\modules\orders\models;

use backend\models\Currencies;
use backend\modules\discount\models\Discount;
use backend\modules\products\models\Products;
use common\models\WbpActiveRecord;
use linslin\yii2\curl\Curl;
use Yii;

class Orders extends WbpActiveRecord
{
    const SCENARIO_ONE_CLICK='one-click';
    const FRONTEND_ADD_SCENARIO = 'frontend-add';

    const STATUS_CREATED=0;
    const STATUS_PREPAYMENT_CONFIRMATION=1;
    const STATUS_PAYMENT_CONFIRMATION=1;
    const STATUS_SHIPPED=8;
    const STATUS_COMPLETED=9;
    const STATUS_CANCELED=10;
    public  $amount,$payment_type;

    public static $order_statuses=[
        'Заказ создан',
        'Подтверждена предоплата',
        'Подтверждена оплата',
        8=>'Заказ отправлен клиенту',
        9=>'Заказ завершен',
        10=>'Закакз Отменен'
    ];
    public static $order_colors=[
        '#514d6a',
        '#01a8fe',
        '#46be8a',
        10=>'#fb434a',
    ];

    public static $imageTypes=['Products'];

    public static $shippingMethods=['Новой почтой', 'Курьером'];
    public static $shippingMethodsPrice=[50,30];

    public $products=[];
    public $currency_id;
    public $discount_code;
    public $return;

    public function rules()
    {
        return [
            [['currency_id','products','first_name','last_name','phone','country_id','address','discount_code',
                'shipping_method','city','delivery_office','comment','shipping_id','shipping_date','shipping_price',
                'shipping_weight','shipping_comment','client_id'
            ],'safe','on'=>[self::ADMIN_EDIT_SCENARIO, self::ADMIN_ADD_SCENARIO]],
            [['currency_id',
                'products',
                'first_name',
                'last_name',
                'phone',
                'country_id',
                'address',
                'discount_code',
                'shipping_method',
                'city',
                'delivery_office',
                'comment',
                'shipping_id',
                'shipping_date',
                'shipping_price',
                'shipping_weight',
                'shipping_comment',
                'client_id',
                'email',
                'payment_type',
            ],'safe','on'=>[ self::FRONTEND_ADD_SCENARIO]],
            [['phone', 'first_name', 'last_name', 'city' ], 'required', 'message' => \Yii::t("app", 'Это обязательное поле'), 'on' => [self::FRONTEND_ADD_SCENARIO]],

            ['delivery_office', 'required', 'when' => function($model) {
                return false;
            }, 'whenClient' => "function (attribute, value) {
    return $('#orders-shipping_method').val() == 0;
}",'on'=>self::FRONTEND_ADD_SCENARIO, 'message' => \Yii::t('app', 'поле не может быть пустым')],
            ['address', 'required', 'when' => function($model) {
                return false;
            }, 'whenClient' => "function (attribute, value) {
    return $('#orders-shipping_method').val() == 1;
}",'on'=>self::FRONTEND_ADD_SCENARIO, 'message' => \Yii::t('app', 'поле не может быть пустым')],

            [['email'], 'email', 'message' => \Yii::t("app", 'Не корректный email'), 'on' => [self::FRONTEND_ADD_SCENARIO]],
            ['phone', 'match', 'pattern' => '/^((\+?38)(-?\d{3})-?)?(\d{3})(-?\d{4})$/', 'message' => \Yii::t("app", 'Некорректный телефон'), 'on' => [self::FRONTEND_ADD_SCENARIO]],
        ];
    }

    public function init()
    {
        $this->return=$_SERVER['REQUEST_URI'];
//        $this->country_id=203;
//        $this->currency_id=1;
        parent::init();
    }

    public function setCurrentRegionSettings(){
        $cookies = Yii::$app->request->cookies;
        $country=$cookies->getValue('country', false);

        if($country) $this->country_id=$country;
        $this->currency_id=\Yii::$app->currency->current->id;
    }

    public static function tableName()
    {
        return '{{%orders}}';
    }

    public function getProductsLinks(){
        return $this->hasMany(OrdersProducts::className(),['order_id'=>'id'])->orderBy('id');
    }

    public function getPayments(){
        return $this->hasMany(OrdersPayments::className(),['order_id'=>'id'])->orderBy('id');
    }

    public function getPayment(){
        return $this->hasOne(OrdersPayments::className(),['order_id'=>'id']);
    }

    public static function getShippingList(){
        return self::$shippingMethods;
    }

    public function getSubTotal($format = true){
//        var_dump($this->products);
        if(!$this->products){
            if($format) return '0.00';
            else return 0;
        }else{
            $total=0;
            foreach ($this->products as $num=>$product){
                if(!isset($product['qty'])) $product['qty']=1;
                if(!isset($product['price'])){
                    $productObject=Products::findOne(['status'=>Products::STATUS_ACTIVE, 'id'=>$product['id']]);
                    $product['price']=$productObject->getPriceByCurrency($this->currency_id)->price;
                }
                $total+=$product['qty']*$product['price'];
            }
            if($format) return number_format($total,2,'.','');
            else return $total;
        }
    }

    public function getCurrency(){
        return Currencies::findOne($this->currency_id);
    }

    public function getPaid($format = true){

        $paid=$this->getPayments()->select("SUM(amount) as value")->one()['value'];

        if($format) return number_format($paid,2,'.','');
        else return $paid;
    }

    public function getDiscount(){
        if($this->discount_id) return Discount::findOne($this->discount_id);
        return Discount::findOneCode($this->discount_code);
    }

    public function getDiscountPrice($format = true){
        $code=$this->getDiscount();
        if(!$code) {
            if($format) return '0.00'.$this->currency->sign;
            else return 0;
        }else{
            if($format) return $code->getDiscountValue($this->getSubTotal(false),$format);
            else return $code->getDiscountValue($this->getSubTotal(false),$format);
        }
    }

    public function getShippingPrice($format = true){
        if(!$this->shipping_method) return 0;
        $total=self::$shippingMethodsPrice[$this->shipping_method];
        if($format) return number_format($total,2,'.','');
        else return $total;
    }

    public function getTotal($format = true){
        $total=$this->getSubTotal(false);
//        $total+=$this->getShippingPrice(false);
//        $total-=$this->getDiscountPrice(false);

        if($format) return number_format($total,2,'.','');
        else return $total;
    }

    public function getBalance($format = true){
        $total=-1*$this->getTotal(false);
        $total+=$this->getPaid(false);

        if($format) return number_format($total,2,'.','');
        else return $total;
    }

    public function beforeSave($insert)
    {
        if($this->scenario==self::FRONTEND_ADD_SCENARIO){
            $session = Yii::$app->session;
            if(!$session->isActive){$session->open();}
            $cart = $session->get('cart');
            foreach($cart as $key => $value){
                $this->products[]=array(
                    'id'=>$key,
                    'qty'=>$value["qty"],
                    'price'=>$value["price"]
                );
            }


        }
        $this->amount=$this->getTotal();

        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
//        if($this->discount_id) $this->discount_code=Discount::findOne($this->discount_id)->code;
        foreach ($this->productsLinks as $link){
            $this->products[]=[
                'id'=>$link->product_id,
                'qty'=>$link->qty,
                'price'=>$link->price,
                'size'=>$link->size_id
            ];
        }
        return parent::afterFind();
    }

    public function getOrderName(){
        return sprintf("%06d",$this->id).' ('.$this->first_name.' '.$this->last_name.', '.$this->amount.$this->currency->sign.')';
    }
    public function getOrderNameWOPrice(){
        return sprintf("%06d",$this->id).' ('.$this->first_name.' '.$this->last_name.')';
    }

    public function beforeValidate()
    {
        foreach ($this->products as $num=>$product){
            $productObject=Products::findOne(['status'=>Products::STATUS_ACTIVE, 'id'=>$product['id']]);
            if(!$productObject){
                unset($this->products[$num]);
            }
        }
        return parent::beforeValidate();
    }

    public function afterSave($insert, $changedAttributes)
    {
        $ids=[];
        foreach ($this->products as $num=>$product){
            $link=OrdersProducts::findOne(['order_id'=>$this->id,'product_id'=>$product['id']]);
            if(!$link){
                $link=new OrdersProducts();
            }
            $productObject=Products::findOne(['status'=>Products::STATUS_ACTIVE, 'id'=>$product['id']]);
            if($this->scenario==self::SCENARIO_ONE_CLICK){
                if(!$productObject) continue;
            }
            if(!isset($product['qty']) || !$product['qty']) $product['qty']=1;
            if(!isset($product['price']) || !$product['price'] || $this->scenario==self::SCENARIO_ONE_CLICK){
                $price=$productObject->getPriceByCurrency($this->currency_id);
                $product['price']=$price->price;
            }
            $link->order_id=$this->id;
            $link->product_id=$product['id'];
            $link->qty=$product['qty'];
            $link->price=$product['price'];
            $link->save();
            $ids[]=$link->id;
        }

        if($this->scenario==self::ADMIN_ADD_SCENARIO || $this->scenario==self::ADMIN_EDIT_SCENARIO){



            foreach ($this->productsLinks as $link){
                if(!in_array($link->id, $ids)) $link->delete();
            }

        }

        if($this->client_id){
            foreach ($this->payments as $payment){
                $payment->client_id=$this->client_id;
                $payment->save();
            }
        }
//            echo "<pre>";var_dump(Yii::$app->request->post("OrdersPayments")['payment_type']);exit;
        if($this->scenario==self::FRONTEND_ADD_SCENARIO) {
            $paymant = new OrdersPayments();
            $paymant->phone = $this->phone;
            $paymant->order_id = $this->id;
            $paymant->payment_type = Yii::$app->request->post("OrdersPayments")['payment_type'];
            $paymant->status = self::STATUS_CREATED;
            $paymant->amount = $this->amount;
            $paymant->save();

                if(Yii::$app->request->post("OrdersPayments")['payment_type'] == 0) {


                }
        }

        return parent::afterSave($insert, $changedAttributes);
    }

    public function isProductsAvailable(){
        foreach ($this->productsLinks as $link){
            if(!$link->isReserved()) return false;
        }
        return true;
    }

    public function attributeLabels()
    {
        return [
            'currency_id'=>'Валюта',
            'first_name'=>'Имя',
            'last_name'=>'Фамилия',
            'phone'=>'Телефон',
            'shipping_method'=>'Метод доставки',
            'country_id'=>'Страна',
            'city'=>'Город',
            'delivery_office'=>'Отделение',
            'address'=>'Адрес',
            'discount_code'=>'Дисконт',
            'comment'=>'Коментарий',
            'shipping_id'=>'Номер посылки',
            'shipping_date'=>'Дата Доставки',
            'shipping_price'=>'Цена доставки',
            'shipping_weight'=>'Вес посылки (кг)',
            'shipping_comment'=>'Комментарий доставки',
            'client_id'=>'Пользователь',
//            ''=>'',
//            ''=>'',
        ];
    }

}
