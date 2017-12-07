<?php
/**
 * Created by PhpStorm.
 * User: Maksim Sergeevich (doctorpepper608@gmail.com)
 * Date: 09.03.2016
 * Time: 16:19
 */
namespace frontend\models;

use common\models\WbpActiveRecord;

class LocalUserExperienceTypes extends WbpActiveRecord{

    public static function tableName()
    {
        return '{{%clients_experience_types}}';
    }
}