<?php
/**
 * Created by PhpStorm.
 * User: tricktrick
 * Date: 01/11/16
 * Time: 10:22
 */

namespace common\models;


class CardTypes extends WbpActiveRecord
{
    public static function tableName()
    {
        return '{{%card_types}}';
    }


    public static function getMonthes($first=true){
        if($first) $result = ['MONTH'];
        else $result = [];

        for($i=1;$i<=12;$i++){
            $result[$i]=sprintf("%02d",$i);
        }

        return $result;
    }

    public static function getYears($first=true){
        if($first) $result = ['YEAR'];
        else $result = [];
        for($i=date("Y");$i<date("Y")+12;$i++){
            $result[substr($i,2,2)]=sprintf("%04d",$i);
        }

        return $result;
    }


}