<?php

namespace backend\modules\orders\models;

use backend\modules\products\models\Products;
use Yii;

class Cart extends Orders
{
    public $cart;

    public function init()
    {
        parent::init();

        $cookies = Yii::$app->request->cookies;
        $country=$cookies->getValue('country', false);

        $this->restoreCart();

        if($country && !$this->country_id) $this->country_id=$country;
        if(!$this->currency_id) $this->currency_id=\Yii::$app->currency->current->id;
    }

    public function rules()
    {
        return [
            [['first_name','phone', 'products'],'required'],
            [['return'],'safe'],
        ];
    }

    public function addProduct($product_id, $qty=1, $size=''){
        $product=Products::findOne(['status'=>Products::STATUS_ACTIVE, 'id'=>$product_id]);
        if(!$product) return false;
        if($qty<=0) $qty=1;
        $qty=(int)$qty;

        if(!$size){
            $sizes=$product->getSizesList();
            foreach ($sizes as $size=>$title) break;
        }

        $found=false;
        if(is_array($this->products)){
            foreach ($this->products as $num=>$prd) {
                if($prd['id']==$product->id && $prd['size']==$size){
                    $found=true;
                    $this->products[$num]['qty']=$prd['qty']+$qty;
                }
            }
        }
        if(!$found){
            $price=$product->getPriceByCurrency($this->currency_id);
            $this->products[]=[
                'id'=>$product->id,
                'qty'=>$qty,
                'size'=>$size,
                'price'=>$price->price
            ];
        }

        $this->saveCart();
    }

    public function updateProduct($num, $product_id, $qty=1, $size=''){
        $product=Products::findOne(['status'=>Products::STATUS_ACTIVE, 'id'=>$product_id]);
        if(!$product) return false;
        if($qty<=0) $qty=1;
        $qty=(int)$qty;

        if(!$size){
            $sizes=$product->getSizesList();
            foreach ($sizes as $size=>$title) break;
        }

        $price=$product->getPriceByCurrency($this->currency_id);
        $this->products[$num]=[
            'id'=>$product->id,
            'qty'=>$qty,
            'size'=>$size,
            'price'=>$price->price
        ];

        $this->saveCart();
    }

    public function removeProduct($num){
        unset($this->products[$num]);

        $this->saveCart();
    }

    public function saveCart(){
        $this->cart=$this->getAttributes();
        $this->cart['products']=$this->products;

        \Yii::$app->session->set('cart',$this->cart);
    }

    public function clear(){
        $this->cart['products']=[];
        \Yii::$app->session->set('cart','');
//        Yii::$app->cart=new self;
    }

    public function restoreCart(){
        $this->cart=\Yii::$app->session->get('cart');
        $this->load($this->cart, '');
        if(isset($this->cart['products'])) $this->products=$this->cart['products'];
        if(is_array($this->products)) {
            foreach ($this->products as $num => $product) {
                $prd = Products::findOne(['status' => Products::STATUS_ACTIVE, 'id' => $product['id']]);
                $this->products[$num]['price'] = $prd->getPriceByCurrency($this->currency_id)->price;
            }
        }
    }

    public function getLegend(){
        $count=count($this->products);
        if(!$count) return '';
        return $count." <span class=\"total-price\">— ".$this->getTotal()."</span>";
    }

}