<?php

namespace frontend\models;

use backend\modules\clients\models\Client;
use backend\modules\mailTemplates\models\MailTemplates;
use common\models\Config;
use wbp\eStoreApi\User;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class ForgotPasswordForm extends Model
{
    public $email;

    public function rules()
    {
        return [
            ['email', 'validateExistingOfEmail'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'filter', 'filter' => 'trim'],
            ['email','safe']
        ];
    }

    public function validateExistingOfEmail()
    {
        if(!Client::findByEmail($this->email)) {
            $this->addError("email", \Yii::t("app", 'Пользователя с таким email не существует'));

            return false;
        }else{
            return true;
        }
    }

    public function forgotPassword(){
        if($this->validateExistingOfEmail()){
            $user=Client::findByEmail($this->email);
            $user->sendResetPasswordMail();
        }


    }


}