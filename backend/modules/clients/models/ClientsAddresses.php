<?php
    namespace backend\modules\clients\models;

    use common\models\WbpActiveRecord;


    class ClientsAddresses extends WbpActiveRecord
    {

        public static function tableName()
        {
            return '{{%clients_addresses}}';
        }

    }