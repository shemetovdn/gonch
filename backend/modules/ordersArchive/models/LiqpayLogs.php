<?php
namespace backend\modules\ordersArchive\models;

use backend\models\Currencies;
use backend\modules\discount\models\Discount;
use backend\modules\products\models\Products;
use common\models\WbpActiveRecord;
use linslin\yii2\curl\Curl;
use Yii;

class LiqpayLogs extends WbpActiveRecord
{

    public function rules()
    {
        return [
            [['transaction_id',
                'status',
                'paytype',
                'acq_id',
                'order_id',
                'liqpay_order_id',
                'sender_phone',
                'sender_card_mask2',
                'sender_card_bank',
                'sender_card_type',
                'create_date',
                'note',
                'result'

            ],'safe'],
        ];
    }

    public function init()
    {
        parent::init();
    }

    public static function tableName()
    {
        return '{{%liqpay_logs}}';
    }


}
