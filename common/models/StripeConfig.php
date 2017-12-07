<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 7/4/2016
 * Time: 09:33
 */

namespace common\models;

use common\models\Config;


class StripeConfig
{

    public static function getAuthenticationKey(){
        $is_live=Config::getParameter('stripe_live',false);
        if($is_live) return self::getLiveKey();
        return self::getTestKey();
    }

    public static function getTestKey(){
        return Config::getParameter('stripe_test_key',false);
    }

    public static function getLiveKey(){
        return Config::getParameter('stripe_key',false);
    }
    
}