<?php
/**
 * Created by PhpStorm.
 * User: Maksim Sergeevich (doctorpepper608@gmail.com)
 * Date: 09.03.2016
 * Time: 16:19
 */
namespace frontend\models;

use common\models\WbpActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

class LocalUserDB extends WbpActiveRecord
{

    public static $imageTypes = ["ProfileImage", "ProfilePhotos"];

    public static function tableName()
    {
        return '{{%clients}}';
    }

    public function rules()
    {
        return [
            [
                ['username', 'password'], 'safe'
            ]
        ];
    }


}