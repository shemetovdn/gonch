<?php

namespace backend\modules\ordersArchive\controllers;

use backend\controllers\OneModelBaseController;
use backend\models\UserLog;
use backend\modules\clients\models\Client;
use backend\modules\ordersArchive\models\NovaPoshta;
use backend\modules\ordersArchive\models\Orders;
use backend\modules\ordersArchive\models\OrdersPayments;
use backend\modules\products\models\Products;
use backend\modules\ordersArchive\models\SearchModel;
use Yii;

class DefaultController extends OneModelBaseController
{
    public $UserModelName;
    public $novaposhta;
    public $payment;

    public function init()
    {
        $this->ModelName = Orders::className();
        $this->searchModel = new SearchModel();

        $this->novaposhta=new NovaPoshta();
        $this->payment=new OrdersPayments();

        return parent::init();
    }

    public function actionIndex()
    {
        $modelName = $this->ModelName;
        $searchModel = new SearchModel();
        $params = \Yii::$app->request->get();
        $dataProvider = $searchModel->search($modelName, $params);

        return $this->render('index', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
    }

    public function actionAdd(){
        $this->trigger(self::BEFORE_ADD);                                                   // Вызываем события
        $this->trigger(self::BEFORE_ADD_EDIT);

        $modelName = $this->ModelName;                                                        // Находим имя нашей модели

        $formModel = new $modelName(['scenario' => self::ADD_SCENARIO_NAME]);                 // создаем модель с сценарием добавления

        if($formModel->load(Yii::$app->request->post()) && !Yii::$app->request->isAjax) {                                  // пытаемся загрузить данные из поста
            $this->clearTmpImages();
            if($formModel->save()){                                                         // сохраняем данные в БД
                $this->addToLog(UserLog::ADDED,$formModel->id);                             // добавляем в лог событие
                Yii::$app->getSession()->setFlash('success', $this->successAddMessage);     // добавляем всплывающее сообщение
                return $this->redirect(['edit','id'=>$formModel->id]);                      // редиректим на редактирование элемента
            }else{
                Yii::$app->getSession()->setFlash('error', $this->errorMessage);            // Если что-то пошло не так, тогда сообщение об ошибке
            }
        }

        return $this->render($this->addView,['formModel'=>$formModel]);                     // рендрим вьюшку добавления элемента
    }

    /**
     *
     * @param $id
     * @return string
     */

    public function actionEdit($id){
        $this->trigger(self::BEFORE_EDIT);
        $this->trigger(self::BEFORE_ADD_EDIT);

        $modelName=$this->ModelName;

        $formModel=$modelName::findOne(['id'=>(int)$id]);
        $formModel->scenario=self::UPDATE_SCENARIO_NAME;

        if($formModel->load(Yii::$app->request->post()) && !Yii::$app->request->isAjax){
            $this->clearTmpImages();
            $saved=$formModel->save();
            if($saved){
                $this->addToLog(UserLog::SAVED, $formModel->id);
                Yii::$app->getSession()->setFlash('success', $this->successEditMessage);
                return $this->redirect(['edit','id'=>$formModel->id]);
            }else{
                Yii::$app->getSession()->setFlash('error', $this->errorMessage);
            }
        }

        return $this->render($this->editView,['formModel'=>$formModel]);

    }

    public function getAllProductsProvider($not_id=false){
        $params = \Yii::$app->request->post();
        $searchModel=new SearchModel();
        $dataProvider=$searchModel->search(Products::className(), $params);
        $dataProvider->pagination->pageSize=5;
        return $dataProvider;
    }

    public function actionStatus($id){
        $modelName=$this->ModelName;
        $model=$modelName::findOne($id);
        if(Yii::$app->user->identity->role==2){
            $balance=$model->getBalance(false);
            if($balance>=0)
                $model->status=Orders::STATUS_PAYMENT_CONFIRMATION;
            else
                $model->status=Orders::STATUS_PREPAYMENT_CONFIRMATION;

        }
        $model->save();
        Yii::$app->end();
    }

//    public function actionRemove($id){
//        $modelName=$this->ModelName;
//        $model=$modelName::findOne($id);
//        $model->status=Orders::STATUS_CANCELED;
//        $model->save();
//        Yii::$app->end();
//    }

    public function actionGetClientInfo($id){
        $client=Client::findOne($id);
        if($client){
            $result=[
                'first_name'=>$client->data->first_name,
                'last_name'=>$client->data->last_name,
                'phone'=>$client->data->phone,
            ];
            echo json_encode($result);
            Yii::$app->end();
        }
    }

}
