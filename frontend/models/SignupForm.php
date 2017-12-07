<?php
namespace frontend\models;

use backend\modules\clients\models\Client;
use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }


    public function unique()
    {
        if(Client::find()->where(['username' => $this->email, 'email' => $this->email, ])->one()){
            $this->addError("email", "This email already registered");
        }
    }


    public function register()
    {

        if ($this->validate()) {
            $user = new Client();
            $user->username = $this->email;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->save();

            \Yii::$app->user->login($user, 3600 * 24 * 30);

            return true;
        }

        return null;
    }
}
