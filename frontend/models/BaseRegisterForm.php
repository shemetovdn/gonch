<?php

namespace frontend\models;

use backend\modules\clients\models\Client;
use frontend\models\LocalUser;
use Yii;
use yii\base\Model;
use wbp\eStoreApi\User;

/**
 * LoginForm is the model behind the login form.
 */
class BaseRegisterForm extends Model
{
    public $username;
    public $password;
//    public $password;
    public $password_confirmation;
    public $email;
    public $first_name;
    public $last_name;
    public $phone;



    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'username','first_name','last_name','phone'], 'string', 'max' => 255],
            ['email', 'validateUniqueEmail', 'on' => ['register']],
            ['username', 'validateUniqueUsername', 'on' => ['register']],
            [['email', 'username'], 'filter', 'filter' => 'trim'],
            [['email'], 'email'],
            [['email','username'], 'required', 'on' => ['register']],

            [['username'], 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u', 'message' => '{attribute} can contain only letters, numbers, and "_"'],


            [['password'], 'string', 'min' => 3],
//            [['password'], 'filter', 'filter' => 'trim'],
            [['password','password_confirmation'], 'required', 'on' => ['register']],
            [['password_confirmation'], 'compare', 'compareAttribute' => 'password', 'message' => 'Passwords do not match'],


            [['first_name','last_name','phone'],'safe']
        ];
    }

    public function validateUniqueEmail()
    {
        if(Client::findByEmailWithoutStatus($this->email)) {
            $this->addError("email", "This email already registered");
        }
    }

    public function validateUniqueUsername()
    {
        if(Client::findByUsernameWithoutStatus($this->username)){
            $this->addError("username", "SORRY, THIS USERNAME IS TAKEN");
        }
    }


    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function register()
    {
        if ($this->validate()) {
            $user= new Client();
            $user->load($this->getAttributes(),'');

            $user->username=$this->username;
            $user->setPassword($this->password);
            $user->email=$this->email;
            $user->status=Client::STATUS_ACTIVE;

            $user->save();
            return $user;
        } else {
            return false;
        }
        return true;
    }

    public function attributeLabels()
    {
        return [
            'password_new'     => 'Password',
            'password_confirmation' => 'Password Confirm',
        ];
    }

}
