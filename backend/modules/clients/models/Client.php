<?php
namespace backend\modules\clients\models;

use backend\models\Addresses;
use backend\modules\mailTemplates\models\MailTemplates;
use backend\modules\stores\models\Stores;
use common\models\Config;
use common\models\WbpActiveRecord;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\IdentityInterface;
use backend\modules\products\models\Products;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class Client extends WbpActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 2;
    const STATUS_ACTIVE = 1;
    const STATUS_DISABLED = 0;
    const AFTER_USER_REGISTRATION_MAIL_TEMPLATE = 3;
    const RESET_PASSWORD_MAIL_TEMPLATE = 4;
    const CONFIRM_RESET_PASSWORD_MAIL_TEMPLATE = 5;

    const RESET_PASSWORD_EVENT = 'resetPassword';
    const CONFIRM_RESET_PASSWORD_EVENT = 'confirmResetPassword';

    const EmailUpdateScenario='email-update';
    const UsernameUpdateScenario='username-update';
    const PasswordUpdateScenario='password-update';
    const FnameUpdateScenario='fname-update';

    public $dataRel;
    public $profile;
    public $authKey;

    public static $imageTypes=['Client'];
    public $raw_password, $store;
    protected static $restAdditionalFields = [];
    public $service, $service_id;

    public $new_password, $confirm_password, $subscribe;


    public static function addRestAdditionalFields($field){
        self::$restAdditionalFields[] = $field;
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%clients}}';
    }

    public function getData()
    {
        if(!$this->dataRel){

            $this->dataRel=$this->hasOne(ClientData::className(), ['client_id' => 'id']);
            if(!$this->dataRel->one()){
                $this->dataRel=new ClientData();
                $this->dataRel->client_id=$this->id;
                $this->dataRel->save();
            }
        }
        return $this->dataRel;
    }

    public function getAddresses()
    {
        return $this->hasMany(Addresses::className(), ['id' => 'address_id'])
            ->viaTable(ClientsAddresses::tableName(), ['client_id' => 'id']);
    }

    public function getName(){
        $name = trim($this->data->first_name.' '.$this->data->last_name);
        if(!$name) $name=$this->username;
        if(!$name) $name=$this->email;
        if(!$name) $name="UserId: ".$this->id;
        return $name;

    }

    public function checkAccess(){
        return true;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviours=parent::behaviors();

        return ArrayHelper::merge($behaviours,[
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['username','email','first_name','last_name','phone','password','service', 'service_id','subscribe'],'safe','on'=>['rest-create', 'rest-update']],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED, self::STATUS_DISABLED]],


            [['first_name','last_name'], 'safe', 'on'=>self::FnameUpdateScenario],
            [['first_name'], 'required', 'on'=>self::FnameUpdateScenario],

            [['email'], 'safe', 'on'=>self::EmailUpdateScenario],
            [['email'], 'email', 'on'=>self::EmailUpdateScenario],
            [['email'], 'required', 'on'=>self::EmailUpdateScenario],

            ['email', function ($attribute, $params) {
                $user=Client::findByEmail($this->$attribute);
                if($user)
                    if(($this->id && $user->id!=$this->id) || (!$this->id && $user->id)){
                        $this->addError($attribute, 'You can\'t use this email, please use another.');
                    }
            }, 'on'=>self::EmailUpdateScenario],

            [['username'], 'safe', 'on'=>self::UsernameUpdateScenario],
            [['username'], 'string', 'max' => 30, 'min'=>6,  'on'=>self::UsernameUpdateScenario],
            [['username'], 'required', 'on'=>self::UsernameUpdateScenario],
            ['username', function ($attribute, $params) {
                $user=Client::findByUsername($this->$attribute);
                if($user)
                    if(($this->id && $user->id!=$this->id) || (!$this->id && $user->id)){
                        $this->addError($attribute, 'You can\'t use this username, please use username.');
                    }
            }, 'on'=>self::UsernameUpdateScenario],

            [['new_password','confirm_password'], 'safe', 'on'=>self::PasswordUpdateScenario],
            [['new_password','confirm_password'], 'string', 'max' => 30, 'min'=>6,  'on'=>self::PasswordUpdateScenario],
            [['new_password','confirm_password'], 'required', 'on'=>self::PasswordUpdateScenario],
            ['confirm_password', 'compare', 'compareAttribute'=>'new_password'],

        ]);

    }

    public function setFirst_name($value){
        $this->data->first_name=$value;
    }
    public function getFirst_name(){
        return $this->data->first_name;
    }
    public function setLast_name($value){
        $this->data->last_name=$value;
    }
    public function getLast_name(){
        return $this->data->last_name;
    }
    public function setPhone($value){
        $this->data->phone=$value;
    }
    public function getPhone(){
        return $this->data->phone;
    }

    public function setCity($value){
        $this->data->city=$value;
    }
    public function getCity(){
        return $this->data->city;
    }

    public function getService(){
        return $this->data->service;
    }

//    public function setLast_name($value){
//        $this->data->last_name=$value;
//    }
//    public function setPhone($value){
//        $this->data->phone=$value;
//    }

    public function beforeSave($insert){
        if(!$this->auth_key) $this->generateAuthKey();
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        $this->data->client_id=$this->id;
        $attr = $this->attributes;
        unset($attr['id']);
        $this->data->load($attr,'');
        $this->data->save();

    }


//    public function getAddresses()
//    {
//        $ca=ClientsAddresses::findAll(['client_id'=>$this->getClientId()]);
//        $ids=[];
//        foreach ($ca as $clientAddressRelation){
//            $ids[]=$clientAddressRelation->address_id;
//        }
//        return Addresses::find()->where(['id'=>$ids]);
//    }

    public function getAddressByType($type=0){
        $addresses=$this->getAddresses()->all();
        foreach ((array)$addresses as $address){
            if($address->type==$type) return $address;
        }

        $new_address=new Addresses();
        $new_address->type=$type;
        $new_address->save();

        $ca=new ClientsAddresses();
        $ca->address_id=$new_address->id;
        $ca->client_id=$this->id;
        $ca->save();

        return $new_address;
    }

    public function getBillingAddress(){
        return $this->getAddressByType(Addresses::BILLING_ADDRESS_TYPE);
    }

    public function getShippingAddress(){
        return $this->getAddressByType(Address::SHIPPING_ADDRESS_TYPE);
    }


    public function fields(){
        $fields =  [
            'id',
            'username',
            'is_member_price',
//            'auth_key',
            'email',
            'status',
            'password_hash',
            'first_name'=>function ($model) {
                return $model->data->first_name;
            },
            'last_name'=>function ($model) {
                return $model->data->last_name;
            },
            'phone'=>function ($model) {
                return $model->data->phone;
            }
        ];
        return ArrayHelper::merge($fields,self::$restAdditionalFields);
    }

    public function extraFields(){
        return [
            'addresses'
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByUsernameWithoutStatus($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

     public static function findByEmailWithoutStatus($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
//        if (!static::isPasswordResetTokenValid($token)) {
//            return null;
//        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function getPassword(){
        return false;
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->raw_password = $password;
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = md5($this->id . '_' . time());
//        $this->trigger(self::RESET_PASSWORD_EVENT);
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getEauth()
    {
        // Customer has_many Order via Order.customer_id -> id
        return $this->hasMany(ClientEauth::className(), ['user_id' => 'id']);
    }

    public function getCards(){
        return $this->hasMany(ClientCreditCard::className(), ['client_id' => 'id']);
    }

    public function init()
    {
        if(empty($this->profile)){
            $this->on(self::EVENT_AFTER_INSERT, [$this, 'sendRegistrationMail']);
        }
        $this->on(self::RESET_PASSWORD_EVENT, [$this,'sendResetPasswordMail']);
        $this->on(self::CONFIRM_RESET_PASSWORD_EVENT, [$this,'sendConfirmResetPasswordMail']);
        parent::init();
    }

    public function confirmResetPassword($strength = 8){
        $this->removePasswordResetToken();
        $newPassword = Yii::$app->getSecurity()->generateRandomString($strength);
        $this->setPassword($newPassword);
        $this->save();
        $this->sendConfirmResetPasswordMail();
//        $this->trigger(self::CONFIRM_RESET_PASSWORD_EVENT);
        return true;
    }

    public function sendRegistrationMail(){
        $query=new Query();
        $query->select('created_at')->from(self::tableName())->where(['id'=>$this->id]);
        $created_at=$query->one()['created_at'];

        $replacements=[
            '%user_fname%'=>$this->first_name,
            '%user_lname%'=>$this->last_name,
            '%user_email%'=>$this->email,
            '%user_password%'=>$this->raw_password,
            '%username%'=>$this->username,
            '%user_registration_date%'=>Yii::$app->formatter->asDatetime($created_at,'medium'),
        ];

        $this->sendTemplateMail(self::AFTER_USER_REGISTRATION_MAIL_TEMPLATE,$replacements);
    }

    public function sendResetPasswordMail(){
        $this->generatePasswordResetToken();
        $this->save();

        $replacements=[
            '%user_fname%' =>$this->first_name,
            '%user_lname%' =>$this->last_name,
            '%user_email%' =>$this->email,
            '%password_reset_link%' =>'<a href="'.Url::to(['auth/confirm-reset-password','token'=>$this->password_reset_token],true).'">Click here to reset password</a>' //TODO: maybe do on HTML helper
        ];
        $this->sendTemplateMail(self::RESET_PASSWORD_MAIL_TEMPLATE,$replacements);

    }

    public function sendConfirmResetPasswordMail(){
        $replacements=[
            '%user_fname%' =>$this->first_name,
            '%user_lname%' =>$this->last_name,
            '%user_email%' =>$this->email,
            '%username%' =>$this->username,
            '%new_user_password%' =>$this->raw_password
        ];
        $this->sendTemplateMail(self::CONFIRM_RESET_PASSWORD_MAIL_TEMPLATE,$replacements);
    }

    protected function sendTemplateMail($templateId,$replacements){
//        mail($this->email,'SUBJECT2', 'MESSAGE2');
        $template=MailTemplates::find()->where(['type_id'=>$templateId])->one();
        if($template && $replacements) {
            $message = Yii::$app->mailer->setTemplate($template, $replacements);

            $message->setFrom([Config::getParameter('email') => Config::getParameter('title')]);

            $send_res = $message->setTo([
                $this->email => trim($this->first_name . ' ' . $this->last_name)
            ])->send();
//            var_dump($send_res);exit;
        }
    }




    /**
     * @param \nodge\eauth\ServiceBase $service
     * @return User
     * @throws ErrorException
     */
    public static function findByEAuth($service) {
        if (!$service->getIsAuthenticated()) {
            throw new ErrorException('EAuth user should be authenticated before creating identity.');
        }

        $id = $service->getServiceName().'-'.$service->getId();
        $attributes = array(
            'id' => $id,
            'username' => $service->getAttribute('name'),
            'authKey' => md5($id),
            'profile' => $service->getAttributes(),
        );
        $attributes['profile']['service'] = $service->getServiceName();
        Yii::$app->getSession()->set('user-'.$id, $attributes);
        return new self($attributes);
    }

    public function getDesire()
    {
        return $this->hasMany(Products::className(), ['id' => 'product_id'])
            ->viaTable('wbp_desire', ['user_id' => 'id']);
    }
    public static function CheckReturn(){
        $session = Yii::$app->session;
        if(!$session->isActive){$session->open();}
        $return = $session->get('return');
        if(!empty($return)){
            return true;
        }else{
            return false;
        }
    }

}
