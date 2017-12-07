<?php

namespace frontend\models;

use backend\models\Addresses;
use backend\modules\clients\models\ClientCreditCard;
use backend\modules\clients\models\ClientsAddresses;
use common\models\CardTypes;
use backend\modules\clients\models\Client;
use Yii;
use yii\helpers\ArrayHelper;

class RegisterForm extends BaseRegisterForm
{
    public $country_id;
    public $state_id;
    public $user_city;
    public $code;
    public $address;
    public $address1;
    public $zip;

    public $cardholder_name;
    public $type_id;
    public $expired_month;
    public $expired_year;
    public $cvv;
    public $number;
    public $agree;

    public $password;
    public $password_confirmation;

    public $username;
    public $email;
    public $phone;

    public function rules()
    {
        $rules = [
            [['username', 'email', 'password', 'password_confirmation', 'phone'], 'safe'],
            [['username', 'email', 'password', 'password_confirmation', 'phone'], 'required', 'message' => \Yii::t("app", 'Это обязательное поле')],
            ['username',
                'validateUniqueUsername'],
            ['email',
                'validateUniqueEmail'],
            ['phone', 'match', 'pattern' => '/^((\+?38)(-?\d{3})-?)?(\d{3})(-?\d{4})$/', 'message' => \Yii::t("app", 'Некорректный телефон')],
            ['password', 'string', 'min' => 6, 'message' => 'Пароль не меньше 6 символов'],
            ['password_confirmation', 'compare', 'compareAttribute' => 'password', 'message' => "Пароли не совпадают"],
        ];
        return $rules;
    }

    public function attributeLabels()
    {
        $labels = [
            'username' => 'Username',
            'password_confirmation' => 'Re-enter Password'
        ];
        return ArrayHelper::merge(parent::attributeLabels(), $labels);
    }


    public function register()
    {

        if ($user = parent::register()) {
            $user->load($this->getAttributes(), '');
            $user->save();

            $user->data->load($this->getAttributes(), '');
            $user->data->save();

            Yii::$app->user->login($user);

            return true;
        } else {
            return false;
        }


    }

    public function validateUniqueEmail()
    {
        if (Client::findByEmailWithoutStatus($this->email)) {
            $this->addError("email", \Yii::t("app", 'Пользователь с таким email уже существует'));
        }
    }


    public function validateUniqueUsername()
    {
        if (Client::findByUsernameWithoutStatus($this->username)) {
            $this->addError("username", \Yii::t("app", 'Имя пользователя уже занято'));
        }

    }

}