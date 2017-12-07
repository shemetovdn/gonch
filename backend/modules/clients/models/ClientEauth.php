<?php

namespace backend\modules\clients\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "{{%client_eauth}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $service_name
 * @property string $service_id
 * @property string $data
 * @property string $created_at
 */
class ClientEauth extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%client_eauth}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function getUser()
    {
        // Order has_one Customer via Customer.id -> customer_id
        return $this->hasOne(Client::className(), ['id' => 'user_id']);
    }



//    public static function findByEAuth($service)
//    {
//        if (!$service->getIsAuthenticated()) {
//            throw new ErrorException('EAuth user should be authenticated before creating identity.');
//        }
//
//        return static::findOne([
//            'service_name' => $service->getServiceName(),
//            'service_id' => $service->getId(),
//        ]);
//    }

    public static function prepareUsername($email = '',$name = ''){
        $result = '';
        if($email != ''){
            $t = explode("@",$email);
            $result = $t[0];
        }elseif($name != ""){
            $result = StringHelper::truncate(str_replace([' '],'_',trim(preg_replace('/[^\00-\255]+/u', '', $name))),20,'');
        }else{
            $result = uniqid()."_".time();
        }
        if($result == '') return self::prepareUsername();

        return $result;
    }

    public static function findByEAuth($data)
    {

        return static::findOne([
            'service_name' => $data->service,
            'service_id' => $data->userData->id,
        ]);
    }

    public static function addNewEAuth($data, $userId='')
    {
        if(!$userId){
            $user=new Client();
            $user->email = $data->userData->email;
            $user->username=self::prepareUsername($data->userData->email,$data->userData->name);
            $user->generateAuthKey();
            if($user->data->first_name != "" || $user->data->last_name != "") {
                $user->data->first_name = $data->userData->first_name;
                $user->data->last_name = $data->userData->last_name;
            }else{
                $user->data->first_name = $data->userData->name;
            }
            $user->save();
        }
        else $user=Client::findIdentity($userId);

        if(!$user->id){
            throw new ErrorException('Error user not found.');
        }

        $eAuth = self::findByEAuth($data);
        if(!$eAuth){
            $eAuth=new self();
            $eAuth->service_name = $data->service;
            $eAuth->service_id = (string)$data->userData->id;
            $eAuth->user_id = $user->id;
            $eAuth->data = json_encode($data);
            $eAuth->save();
        }

        return $user;
    }

//    public static function addNewEAuth($service, $userId='')
//    {
//        if (!$service->getIsAuthenticated()) {
//            throw new ErrorException('EAuth user should be authenticated before creating identity.');
//        }
//
//        $attributes = $service->getAttributes();
//        if(!$userId){
//            $user=new Client();
//            $user->email=$attributes['email'];
//            $user->username=StringHelper::prepareUsername($attributes['name']);
//            $user->generateAuthKey();
//            $user->save();
//            $userData = new ClientData();
//            $userData->user_id=$user->id;
//            $userData->first_name=$attributes['first_name'];
//            $userData->last_name=$attributes['last_name'];
//            $userData->save();
//        }
//        else $user=Client::findIdentity($userId);
//
//        if(!$user->id){
//            throw new ErrorException('Error user not found.');
//        }
//
//
//        $eAuth=new self();
//        $eAuth->service_name=$service->getServiceName();
//        $eAuth->service_id=$service->getId();
//        $eAuth->user_id=$user->id;
//        $eAuth->data=json_encode($attributes);
//        $eAuth->save();
//
//
//        return $eAuth;
//    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'service_name', 'service_id', 'data'], 'required'],
            [['user_id'], 'integer'],
            [['data'], 'string'],
            [['created_at','user_id'], 'safe'],
            [['service_name', 'service_id'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'service_name' => 'Service Name',
            'service_id' => 'Service ID',
            'data' => 'Data',
            'created_at' => 'Created At',
        ];
    }
}
