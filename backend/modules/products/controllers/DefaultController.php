<?php
namespace backend\modules\products\controllers;

use backend\controllers\OneModelBaseController;
use backend\modules\products\models\Products;
use backend\modules\adverts\models\Router;
use backend\modules\adverts\models\SearchModel;
use yii;
use backend\models\UserLog;
use backend\modules\categories\models\Category;
use backend\modules\products\models\Associated;

class DefaultController extends OneModelBaseController
{

    public function init()
    {
        $this->ModelName = Products::className();

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

        if($formModel->load(Yii::$app->request->post())) {                                  // пытаемся загрузить данные из поста
            $this->clearTmpImages();
            if($formModel->save()){                                                         // сохраняем данные в БД
                $this->addToLog(UserLog::ADDED,$formModel->id);                             // добавляем в лог событие
                Yii::$app->getSession()->setFlash('success', $this->successAddMessage);     // добавляем всплывающее сообщение
                return $this->redirect(['edit','id'=>$formModel->id]);                      // редиректим на редактирование элемента
            }else{
                Yii::$app->getSession()->setFlash('error', $this->errorMessage);            // Если что-то пошло не так, тогда сообщение об ошибке
            }
        }
        $category_id = $formModel->category_id;
        if(Yii::$app->request->isAjax){
            $category_id = Yii::$app->request->post('category_id');
        }
        $formModel->cat_fore_params = Category::findOne($category_id);
        return $this->render($this->addView,['formModel'=>$formModel]);                     // рендрим вьюшку добавления элемента
    }

    public function actionEdit($id){

        $this->trigger(self::BEFORE_EDIT);
        $this->trigger(self::BEFORE_ADD_EDIT);

        $modelName=$this->ModelName;

        $formModel=$modelName::findOne(['id'=>(int)$id]);
        $formModel->scenario=self::UPDATE_SCENARIO_NAME;

        if($formModel->load(Yii::$app->request->post())){
            $this->clearTmpImages();
            $saved=$formModel->save();
            if($saved){
                $this->addToLog(UserLog::SAVED, $formModel->id);
                Yii::$app->getSession()->setFlash('success', $this->successEditMessage);
            }else{
                Yii::$app->getSession()->setFlash('error', $this->errorMessage);
            }
        }
        $associated = Associated::find()
            ->where([ "product_id" => $formModel->id])
            ->all();
        $formModel->associated = $associated;
        $category_id = $formModel->category_id;
        if(Yii::$app->request->isAjax){
            $category_id = Yii::$app->request->post('category_id');
//            $associated_id = Yii::$app->request->post('associated_id');
//            if(!empty($associated_id)){
//                Associated::addAssociated($formModel->id, $associated_id);
//            }
        }
        $formModel->cat_fore_params = Category::findOne($category_id);

        return $this->render($this->editView,['formModel'=>$formModel]);

    }





    public function actionGetProduct(){
        $request = \Yii::$app->request;
        if($request->isAjax){
            $id = $request->post('id');
            $row = Products::findOne($id);
            $product = array(
                "title" => $row->title,
                "id" => $row->id,
                "category_title" => $row->category->title,
                "image" => $row->image->getUrl(),
            );
            return json_encode($product);
        }

}

    public function actionDeleteAssociated(){
        $request = \Yii::$app->request;
        if($request->isAjax){
            $id = $request->post('id');
            $product = Associated::findOne($id);

            if(!empty($product)){
                $product->delete();
            }

        }

    }

    public function actionSelectCategory()
    {
        $formModel = new Router();

        return $this->render('select_category',['formModel' => $formModel]);
    }


    public function actionRouteByType()
    {
        $file_name = 'edit';
        $form = Yii::$app->request->post("Router");
        $model = new Router();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
//                Yii::$app->session->setFlash('success', 'Thanks for contacting us!<br>We try to respond as soon as possible, so we will<br>get back to you shortly. In the meantime keep<br>learning about our products.');
                $form = Yii::$app->request->post("Router");
                $category_id = $form["category_id"];
                $object_type_id = $form["object_type_id"];

                $this->redirect(['add','category_id'=>$category_id,'object_type_id'=>$object_type_id]);
                Yii::$app->end();
            } else {
//                echo "<pre>";var_dump($contact);exit;
                Yii::$app->session->setFlash('Error', 'Something wrong, please try again!');
            }

        }
        return $this->render('select_category',['formModel' => $model]);
    }

    public function actionGetObjectTypes(){
        $request = \Yii::$app->request;
        if($request->isAjax){
            $id = $request->post('id');
            $types = \backend\modules\objectTypes\models\ObjectTypes::find()->where(['like','category_ids',''.$id.''])->asArray()->all();
            echo json_encode($types);
        }
    }

}
