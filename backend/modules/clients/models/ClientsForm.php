<?php
namespace backend\modules\clients\models;

use backend\models\BaseFormModel;
use backend\models\Addresses;
use backend\modules\subscribe\models\Subscribe;
use Yii;

/**
 * Login form
 */
class ClientsForm extends BaseFormModel
{
    public $modelName='\backend\modules\clients\models\Client';

    public $id,$username,
        $email,
        $password,
        $first_name,
        $last_name,
        $phone,
        $address,
        $city,
        $service,
        $old_password,
        $new_password,
        $confirm_password,
        $subscribe;
    const FrontendUpdateScenario='frontend-update';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username',
                'email',
                'password',
                'first_name',
                'last_name',
                'phone',
                'address',
                'city',
                'subscribe',
            ],'safe'],
            [['username','password'],'required','on'=>'add'],
            [['username','phone','email'],'required','on'=>'edit', 'message' => \Yii::t('app', 'поле не может быть пустым')],
            ['email', 'email', 'message' => \Yii::t('app', 'некорректно введен емейл')],
            ['username',function ($attribute, $params) {
                if (!ctype_alnum($this->$attribute)) {
                    $this->addError($attribute, 'The name must contain letters or digits.');
                }
            }],
            ['username','unique','targetClass' => Client::className(), 'message' => 'This store name has already been taken.', 'on'=>'add'],
            [[
                'username',
                'email',
                'password',
                'first_name',
                'last_name',
                'phone',
                'address',
                'city',
                'subscribe',
                'old_password',
                'new_password',
                'service'
            ], 'safe', 'on'=>self::FrontendUpdateScenario],
            [['new_password','confirm_password'], 'string', 'max' => 30, 'min'=>6,  'on'=>self::FrontendUpdateScenario],
            [['username','phone','email'], 'required', 'on'=>self::FrontendUpdateScenario, 'message' => \Yii::t('app', 'поле не может быть пустым')],
            ['phone', 'match', 'pattern' => '/^((\+?38)(-?\d{3})-?)?(\d{3})(-?\d{4})$/', 'on'=>self::FrontendUpdateScenario, 'message' => \Yii::t("app", 'Некорректный телефон')],
            ['username',
                'validateUniqueUsername',  'on'=>self::FrontendUpdateScenario],
            ['email',
                'validateUniqueEmail',  'on'=>self::FrontendUpdateScenario],
            ['email', 'email', 'message' => \Yii::t('app', 'некорректно введен емейл'), 'on'=>self::FrontendUpdateScenario],
            ['confirm_password', 'compare', 'compareAttribute'=>'new_password', 'message' => \Yii::t("app", 'Пароли не совпадают')],

            ['old_password', 'required', 'when' => function($model) {
//            var_dump($model);exit;
                return false;
            }, 'whenClient' => "function (attribute, value) {
    return $('#clientsform-new_password').val() != '';
}"
            ,
              'on'=>self::FrontendUpdateScenario, 'message' => \Yii::t('app', 'поле не может быть пустым')],
            ['old_password',function ($attribute, $params) {
                if(!Yii::$app->user->identity->validatePassword($this->{$attribute})){
                    $this->addError($attribute, \Yii::t("app", 'Не верный пароль'));
                }
            },  'on'=>self::FrontendUpdateScenario],
        ];
    }


    public function attributeLabels(){
        return [
            'name'=>'Name',
            'title'=>'Title',
            'token'=>'Auth Key',
            'subscribe'=>\Yii::t('app', 'Подписаться'),
            'username'=>\Yii::t('app', 'Имя пользователя'),
        ];
    }


    public function afterSave(){
        $model=$this->findModel();

        $attributes=$this->getAttributes();
        if($attributes['password']){
            $model->setPassword($attributes['password']);
            $model->generateAuthKey();
        }

        if($this->scenario==self::FrontendUpdateScenario) {
            if(!empty($attributes['new_password'])){
                $model->setPassword($attributes['new_password']);
                $model->generateAuthKey();
            }

        }

        $model->save();

        unset($attributes['id']);
        $model->data->setAttributes($attributes,false);
        $model->data->save();
        if($attributes["subscribe"] == 1){
            Subscribe::SubscribeUser($model->email);
        }else{
            Subscribe::UnsubscribeUser($model->email);
        }

//        echo "<pre>";var_dump($attributes["subscribe"]);exit;
    }


    public function validateUniqueEmail()
    {
        if (Client::find()->where(['email' => $this->email])->andWhere(['!=','id',Yii::$app->user->id])->one()) {
            $this->addError("email", \Yii::t("app", 'Пользователь с таким email уже существует'));
        }
    }


    public function validateUniqueUsername()
    {
        if (Client::find()->where(['username' => $this->username])->andWhere(['!=','id',Yii::$app->user->id])->one()) {
            $this->addError("username", \Yii::t("app", 'Имя пользователя уже занято'));
        }

    }

}
