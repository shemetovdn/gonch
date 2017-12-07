<?php

namespace frontend\controllers;

use backend\modules\clients\models\Client;
use backend\modules\clients\models\ClientCreditCard;
use backend\modules\pages\models\Pages;
use Yii;
use backend\modules\products\models\Desire;
use backend\modules\products\models\Products;
use backend\modules\clients\models\ClientsForm;
use backend\models\UserLog;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\widgets\ActiveForm;

class ProfileController extends BaseController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['wishes'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['wishes'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($href=''){
        if (empty(Yii::$app->user->id)){
            return $this->redirect('/login');
        }
        $page=Pages::findOne(['href'=>'profile']);
        $model=Client::findOne(['id'=>(int)Yii::$app->user->id]);

        $formModelName=ClientsForm::className();

        $formModel=new $formModelName(['scenario' => ClientsForm::FrontendUpdateScenario]);
        $formModel->id=Yii::$app->user->id;
        if (Yii::$app->request->isAjax && $formModel->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($formModel);
        }

        $formModel->load($model->getAttributes(),'');
        $formModel->load($model->data->getAttributes(),'');

        if($formModel->load(Yii::$app->request->post()) && $formModel->validate()){
            $saved=$formModel->save();
            if($saved){
                Yii::$app->getSession()->setFlash('success', Yii::t('app', "Данные сохранены"));
            }else{
                Yii::$app->getSession()->setFlash('error', "Что-то не так");
            }
        }
        $form=$this->renderPartial('index',['formModel'=>$formModel,'model'=>$model]);

        return $this->render('index',['page'=>$page, 'formModel'=>$formModel, 'model'=>$model,'form'=>$form]);
    }

    public function actionWishes(){
        if (empty(Yii::$app->user->id)){
            return $this->redirect('/login');
        }
        $request = Yii::$app->request;
        if($request->isAjax){
            $id = $request->post('id');
            $product = Desire::find()->where(['product_id' => $id, 'user_id' => (int)Yii::$app->user->id])->one();
            if(!empty($product)){
                $product->delete();
            }
        }
        $user=Client::findOne(['id'=>(int)Yii::$app->user->id]);
        $query = $user->getDesire();

        $where = array(
            'status' => 1,
        );
        $query = $query->where($where);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);

        return $this->render("wishes",  ['dataProvider' => $dataProvider]);
    }

    public function actionSaveEmail(){
        $post=Yii::$app->request->post();
        $emailUpdate=clone Yii::$app->user->identity;
        $emailUpdate->scenario=Client::EmailUpdateScenario;

        if($emailUpdate->load($post) && $emailUpdate->validate()){
            $emailUpdate->save();
            Yii::$app->session->setFlash("success", "YOUR INFORMATION<br /> HAS BEEN SUCCESSFULLY UPDATED<br /> IN OUR DATABASE");
            echo "<script>document.getElementById('current-email-address').innerHTML='".$emailUpdate->email."';</script>";
        }else{
            $errors=$emailUpdate->getErrors();
            foreach ($errors as $error) break;
            foreach ($error as $error) break;
            Yii::$app->session->setFlash("error", $error);
        }

        return $this->renderAjax('message');
    }

    public function actionSaveUsername(){
        $post=Yii::$app->request->post();
        $usernameUpdate=clone Yii::$app->user->identity;
        $usernameUpdate->scenario=Client::UsernameUpdateScenario;

        if($usernameUpdate->load($post) && $usernameUpdate->validate()){
            $usernameUpdate->save();
            Yii::$app->session->setFlash("success", "YOUR INFORMATION<br /> HAS BEEN SUCCESSFULLY UPDATED<br /> IN OUR DATABASE");
            echo "<script>document.getElementById('current-username').innerHTML='".$usernameUpdate->username."';</script>";
        }else{
            $errors=$usernameUpdate->getErrors();
            foreach ($errors as $error) break;
            foreach ($error as $error) break;
            Yii::$app->session->setFlash("error", $error);
        }

        return $this->renderAjax('message');
    }

    public function actionSavePassword(){
        $post=Yii::$app->request->post();
        $passwordUpdate=clone Yii::$app->user->identity;
        $passwordUpdate->scenario=Client::PasswordUpdateScenario;

        if($passwordUpdate->load($post) && $passwordUpdate->validate()){
            $password=$passwordUpdate->new_password;
            $passwordUpdate->setPassword($password);
            $passwordUpdate->save();

            Yii::$app->session->setFlash("success", "YOUR INFORMATION<br /> HAS BEEN SUCCESSFULLY UPDATED<br /> IN OUR DATABASE");
        }else{
            $errors=$passwordUpdate->getErrors();
            foreach ($errors as $error) break;
            foreach ($error as $error) break;
            Yii::$app->session->setFlash("error", $error);
        }

        return $this->renderAjax('message');
    }

    public function actionSaveFname(){
        $post=Yii::$app->request->post();
        $fnameUpdate=clone Yii::$app->user->identity;
        $fnameUpdate->scenario=Client::FnameUpdateScenario;

        if($fnameUpdate->load($post) && $fnameUpdate->validate()){
            $fnameUpdate->save();
            Yii::$app->session->setFlash("success", "YOUR INFORMATION<br /> HAS BEEN SUCCESSFULLY UPDATED<br /> IN OUR DATABASE");
            echo "<script>document.getElementById('current-fname').innerHTML='".$fnameUpdate->first_name."';</script>";
            echo "<script>document.getElementById('current-lname').innerHTML='".$fnameUpdate->last_name."';</script>";
        }else{
            $errors=$fnameUpdate->getErrors();
            foreach ($errors as $error) break;
            foreach ($error as $error) break;
            Yii::$app->session->setFlash("error", $error);
        }

        return $this->renderAjax('message');
    }



    public function actionAddCard(){
        $card=new ClientCreditCard();
        $card->client_id=Yii::$app->user->id;
        $card->save();
    }

    public function actionSaveCard(){
        $post=Yii::$app->request->post();

        $card=ClientCreditCard::findOne(['client_id'=>Yii::$app->user->id,'id'=>$post['ClientCreditCard']['id']]);

        if($card && $card->load($post) && $card->validate()){
            $card->save();
            Yii::$app->session->setFlash("success", "YOUR CREDIT CARD HAS BEEN<br />SUCCESSFULLY ADDED TO YOUR PROFILE");
        }else{
            Yii::$app->session->setFlash("error", "Some goes wrong. Please try again.");
        }

        return $this->renderAjax('message');
    }

    public function actionRemoveCard()
    {
        $post = Yii::$app->request->post();

        $card = ClientCreditCard::findOne(['client_id' => Yii::$app->user->id, 'id' => $post['id']]);

        if($card) $card->delete();
    }


    public function actionSaveAddress(){
        $post=Yii::$app->request->post();
        $address=Yii::$app->user->identity->getBillingAddress();

        if($address->load($post) && $address->validate()){
            $address->save();
            Yii::$app->session->setFlash("success", "YOUR INFORMATION<br /> HAS BEEN SUCCESSFULLY UPDATED<br /> IN OUR DATABASE");
        }else{
            Yii::$app->session->setFlash("error", "Some goes wrong. Please try again.");
        }

        return $this->renderAjax('message');
    }

}