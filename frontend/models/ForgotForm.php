<?php
/**
 * Created by PhpStorm.
 ** User: TrickTrick alexeymarkov.x7@gmail.com
 *** Date: 03-Apr-17
 **** Time: 16:28
 */

namespace frontend\models;


use backend\modules\clients\models\Client;
use yii\base\Model;

class ForgotForm extends Model
{

    public $email;

    public function rules()
    {
        return [
            ['email', 'email'],
            ['email', 'required'],
            ['email', 'isValid'],
        ];
    }

    public function isValid($attribute, $params, $validator)
    {
        $client = Client::findByEmail($this->$attribute);
        if (!$client) {
            $this->addError($attribute, 'Sorry, wrong email.');
            \Yii::$app->session->setFlash('error', 'Sorry, wrong email.');
        }
    }

    public function generateNewPassword()
    {
        $client = Client::findByEmail($this->email);
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = mb_strlen($chars);

        for ($i = 0, $result = ''; $i < 8; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }
        $client->setPassword($result);
        $client->save();
        return $result;
    }
}