<?php

namespace common\models;

class UserMerchant extends WbpActiveRecord
{
    public static function tableName()
    {
        return '{{%user_merchant}}';
    }
}
