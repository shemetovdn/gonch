<?php

namespace backend\modules\clients\models;
use backend\models\CreditCardType;
use common\models\CardTypes;
use common\models\WbpActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class ClientCreditCard extends WbpActiveRecord{

    public $agree;
    const CreateFrontendScenario='create_cc';

    public static function tableName()
    {
        return '{{%clients_credit_card}}';
    }

    public function behaviors()
    {
        $behaviours=parent::behaviors();
        return ArrayHelper::merge($behaviours,[
            'encryption' => [
                'class' => '\nickcv\encrypter\behaviors\EncryptionBehavior',
                'attributes' => [
                    'cardholder_name',
                    'expired_month',
                    'expired_year',
                    'cvv',
                    'number'
                ],
            ],
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ]
        ]);
    }

    public function getType(){
        return $this->hasOne(CardTypes::className(), ['id' => 'type_id']);
    }

    public function rules()
    {
        return [
            [['client_id','cardholder_name','type_id','expired_month','expired_year','cvv','number'],'safe'],
            [['cardholder_name','type_id','expired_month','expired_year','cvv','number','agree'],'safe', 'on'=>[self::CreateFrontendScenario]],
            [['cardholder_name','type_id','expired_month','expired_year','cvv','number'],'required', 'on'=>[self::CreateFrontendScenario]],
            ['agree', 'required', 'requiredValue' => 1, 'message' => 'Agree with terms and conditions', 'on'=>[self::CreateFrontendScenario]],
            ['expired_month', 'in', 'range' => array_keys(CardTypes::getMonthes(false)), 'message'=>'Invalid Expiration Month', 'on'=>[self::CreateFrontendScenario]],
            ['expired_year', 'in', 'range' => array_keys(CardTypes::getYears(false)), 'message'=>'Invalid Expiration Year', 'on'=>[self::CreateFrontendScenario]],
            ['type_id', 'in', 'range' => array_keys(CardTypes::getList()), 'message'=>'Invalid Credit Card Type', 'on'=>[self::CreateFrontendScenario]],
            ['number', 'wbp\CreditCardValidator', 'message'=>'Your Card Number is incorrect.', 'on'=>[self::CreateFrontendScenario]],
//            [['expired_month','expired_year','type_id'],'required', 'on'=>self::CreateFrontendScenario, 'when' => function ($model, $attribute) {
//                return ($model->{$attribute} == 0)?false:true;
//            }, 'whenClient' => "function (attribute, value) {
//            alert((value == 0)?false:true);
//                return (value == 0)?false:true;
//            }"],
        ];
    }

    public function fields()
    {
        return  [
            'id',
            'client_id',
            'created_at',
            'updated_at',
            'cardholder_name',
            'expired_month',
            'expired_year',
            'cvv',
            'number',
            'type_id',
            'type'=>function($model){
                return $model->type;
            }
        ];
    }
}