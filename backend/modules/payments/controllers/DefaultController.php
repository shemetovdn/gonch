<?php

namespace backend\modules\payments\controllers;

use backend\controllers\OneModelBaseController;
use backend\modules\orders\models\OrdersPayments;
use backend\modules\payments\models\SearchModel;
use Yii;

class DefaultController extends OneModelBaseController
{
    public function init()
    {
        $this->ModelName = OrdersPayments::className();
        $this->searchModel = new SearchModel();

        return parent::init();
    }

    public function actionStatus($id){
        $modelName=$this->ModelName;
        $model=$modelName::findOne($id);
        $model->status=1;
        $model->save();
        Yii::$app->end();
    }

}
