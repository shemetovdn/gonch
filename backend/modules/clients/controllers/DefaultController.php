<?php

namespace backend\modules\clients\controllers;

use backend\controllers\BaseController;
use backend\models\UserLog;
use backend\modules\clients\models\Client;
use backend\modules\clients\models\ClientsForm;
use backend\modules\clients\models\Permissions;
use backend\modules\clients\models\SearchModel;
use Yii;

class DefaultController extends BaseController
{
    public function init(){
        $this->FormModel=ClientsForm::className();
        $this->ModelName=Client::className();

        return parent::init();
    }

    public function actionIndex(){
        $modelName=$this->ModelName;
        $searchModel=new SearchModel();
        $params=\Yii::$app->request->get();
        $dataProvider=$searchModel->search($modelName,$params);

        return $this->render('index',['dataProvider'=>$dataProvider,'searchModel'=>$searchModel]);
    }

    public function actionEdit($id){
        $modelName=$this->ModelName;

        $model=$modelName::findOne(['id'=>(int)$id]);

        $formModelName=$this->FormModel;

        $formModel=new $formModelName(['scenario' => 'edit']);
        $formModel->id=$id;

        $formModel->load($model->getAttributes(),'');
        $formModel->load($model->data->getAttributes(),'');

        if($formModel->load(Yii::$app->request->post())){
            $saved=$formModel->save();
            if($saved){
                $this->addToLog(UserLog::SAVED,$formModel->id);
                Yii::$app->getSession()->setFlash('success', $this->successEditMessage);
            }else{
                Yii::$app->getSession()->setFlash('error', $this->errorMessage);
            }
        }

        $form=$this->renderPartial($this->formView,['formModel'=>$formModel,'model'=>$model]);

        return $this->render($this->editView,['model'=>$model,'form'=>$form]);
    }


}
