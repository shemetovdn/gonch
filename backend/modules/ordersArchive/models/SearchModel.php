<?php

namespace backend\modules\ordersArchive\models;

use backend\models\BaseSearchModel;
use yii\data\ActiveDataProvider;

class SearchModel extends BaseSearchModel
{
    public $from,
        $to,
        $search,
        $per_page=20,
        $order;

    public static $pageSizeList=[
        '10'=>'10',
        '20'=>'20',
        '50'=>'50',
        '100'=>'100',
        '-1'=>'все'
    ];

    public function rules()
    {
        return [
            [['order', 'from', 'to', 'search','per_page'], 'safe']
        ];
    }

    public function search($modelName,$params)
    {
        $query = $modelName::find()->where(['=','status',10]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'key' => 'id'
        ]);

        $query=$this->getOrder($query);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }


        if($this->search!=''){
            $query=$query->andWhere(['like',"title",$this->search]);
        }


        return $dataProvider;
    }

    public function attributeLabels()
    {
        return [
            'from' => 'Added From:',
            'to' => 'Added To:',
            'order' => \Yii::t('admin', 'Sort By:'),
        ];
    }
}