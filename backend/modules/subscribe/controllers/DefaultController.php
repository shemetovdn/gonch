<?php

namespace backend\modules\subscribe\controllers;

use backend\controllers\BaseController;
use backend\modules\subscribe\models\SearchModel;
use backend\modules\subscribe\models\Subscribe;
use backend\modules\subscribe\models\SubscribeAnswers;
use Yii;
use yii\data\ActiveDataProvider;


class DefaultController extends BaseController
{

    public $title;

    public function init()
    {
        $this->ModelName = Subscribe::className();
        $this->title = 'Subscribers';

        return parent::init();
    }


    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Subscribe::find()->where('1')
                ->orderBy('id DESC'),
        ]);

        $modelName = $this->ModelName;
        $searchModel = new SearchModel();
        $params = \Yii::$app->request->get();
        //$dataProvider = $searchModel->search($modelName, $params);

        $modelAnswer = new SubscribeAnswers();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'modelAnswer' => $modelAnswer
        ]);
    }


    public function actionView($id)
    {
        $modelName = $this->ModelName;
        $model = $modelName::findOne(['id' => (int)$id]);
        $formModelName = $this->FormModel;
        $formModel = new $formModelName(['scenario' => 'view']);
        $formModel->loadModel($model->id);

        return $this->render('view', ['model' => $model, 'formModel' => $formModel]);
    }

    public function actionCreateAnswer()
    {
        $model = new SubscribeAnswers(); // answer
        $model->load(Yii::$app->request->post());

        $modelForm = Subscribe::findOne(Yii::$app->request->post()['Subscribe']['id']);
        if (!$modelForm) {
            die('Ah tu hutryn4uk');
        }

        $model->link('contact', $modelForm);

        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Reply was successfully send');
        } else {
            Yii::$app->session->setFlash('error', 'Something wrong!');
        }
        return $this->redirect('index');
    }

    public function actionPopup($id)
    {
        $model = Subscribe::findOne($id);
        $formModel = new SubscribeAnswers();
        return $this->renderAjax('_modal', ['formModel' => $formModel, 'model' => $model]);
    }


}
