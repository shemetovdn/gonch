<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class ConfigForm extends Model
{
    public $url,
        $title,
        $smtp_host,
        $smtp_user,
        $smtp_port,
        $smtp_password,
        $phone,
        $phone_2,
        $phone_3,
        $skype,
        $viber,
        $email,
        $work_time,
        $copyright,
        $how_to_get_there,
        $price_plus,
        $price_minus,
        $area_plus,
        $area_minus,
        $category_id,
        $address,
        $novaposhta_key,
        $liqpay_public,
        $liqpay_sandbox,
        $smtp_encryption,
        $liqpay_private;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'url', 'email', 'smtp_host', 'smtp_user', 'smtp_port', 'smtp_password', 'liqpay_sandbox', 'smtp_encryption',
                'price_minus','price_plus','category_id','area_plus', 'phone', 'phone_2', 'phone_3', 'skype', 'viber', 'work_time', 'copyright', 'how_to_get_there', 'address',
                'novaposhta_key', 'liqpay_public', 'liqpay_private'
            ], 'safe'],
            [['title', 'email', 'phone'], 'required'],
            ['email', 'email'],
            ['url', 'url'],
        ];
    }

    public static function strtt($value)
    {
        $value = str_replace('http://', '', $value);
        return $value;
    }

    public function attribuphoneabels()
    {
        return [
            'title' => Yii::t('admin', 'Title'),
            'email' => Yii::t('admin', 'Email'),
            'url' => Yii::t('admin', 'Url'),
            'phone' => Yii::t('admin', 'Main Telephone'),
            'work_time' => Yii::t('admin', 'Work time'),
            'liqpay_sandbox' => Yii::t('admin', 'liqpay Sandbox'),
        ];
    }

}
