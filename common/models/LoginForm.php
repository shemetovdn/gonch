<?php
namespace common\models;

use backend\modules\clients\models\Client;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Login form
 */
class LoginForm extends Model
{
    static $userClass;
    public $email;
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = null;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password'], 'safe'],
            [['email', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            ['email', 'emailExist'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function emailExist($attribute, $params)
    {
        if (!$this->getUser()) {
            return $this->addError($attribute, 'Incorrect email/username.');
        }
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user->validatePassword($this->password)) {
                return $this->addError($attribute, 'Incorrect password.');
            }

        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        /** @var $userClass Client */
        $userClass = self::getUserClass();
        if ($this->_user === null) {
            $this->_user = $userClass::findByEmail($this->email);
        }

        if ($this->_user === null) {
            $this->_user = $userClass::findByUsername($this->email);
        }

        return $this->_user;
    }

    public static function getUserClass()
    {
        if(!self::$userClass) self::$userClass = Yii::$app->user->identityClass;
        return self::$userClass;
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'email' => 'Email / Username'
        ]);
    }


}
