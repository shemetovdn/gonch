<?php

namespace frontend\models;

use common\models\WbpActiveRecord;


class SearchForm extends WbpActiveRecord
{

    public $q;
    /**
     * @return string название таблицы, сопоставленной с этим ActiveRecord-классом.
     */
    public static function tableName()
    {
        return '{{%products}}';
    }

    public function rules()
    {
        return [
            ['q', 'string'],
            [['q'], 'required', 'message' => 'Уточните параметры поиска'],
        ];
    }
}
