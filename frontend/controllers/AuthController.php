<?php

namespace frontend\controllers;

use backend\modules\clients\models\Client;
use frontend\models\ForgotPasswordForm;
use frontend\models\LoginForm;
use nodge\eauth\ErrorException;
use frontend\models\RegisterForm;
use yii\web\HttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use backend\modules\products\models\Desire;
use Yii;
use yii\helpers\Url;

class AuthController extends BaseController
{
    public function actionLogin()
    {
        $this->redirectRegistered();
        $loginFormModel = new LoginForm();

        /*EAUTH*/
        $this->eauthLogin();
        /*END EAUTH*/

        if (Yii::$app->request->isAjax) {
            if ($loginFormModel->load(Yii::$app->request->post()) && !$loginFormModel->validate()) {
//                if($loginFormModel->username=='qweqwe') var_dump($loginFormModel->getUser());
                Yii::$app->response->format = Response::FORMAT_JSON;
                echo json_encode(ActiveForm::validate($loginFormModel));
                Yii::$app->end();
            }
        }

        if ($loginFormModel->load(Yii::$app->request->post())) {

            $loginFormModel->login();
            $response = Desire::AddToWishlist();
            if($response || Client::CheckReturn()){
               return $this->redirect(['profile/wishes']);
            }
//            $return=Yii::$app->session->get('return',false);
//            if($return){
//                Yii::$app->session->set('return',false);
//                return $this->redirect($return);
//            }
//            $return=Yii::$app->session->get('return',false);
//            if($return){
//                Yii::$app->session->set('return',false);
//                return $this->redirect($return);
//            }


        }

        if(Yii::$app->user->id) return $this->redirect(['profile/index']);

        return $this->render('login',['loginFormModel'=>$loginFormModel]);
    }

    protected function eauthLogin()
    {
        //facebook errors
        if (Yii::$app->request->get("error_description") != "") {
            Yii::$app->getSession()->setFlash('error', 'Facebook login error: ' . Yii::$app->request->get("error_description") . " [" . Yii::$app->request->get("error") . "]");
            return $this->redirect(['auth/signup']);
        }
        //twitter errors
        if (Yii::$app->request->get("denied") != "") {
            Yii::$app->getSession()->setFlash('error', 'Twitter login error: Access Denied');
            return $this->redirect(['auth/signup']);
        }

        $serviceName = Yii::$app->getRequest()->getQueryParam('service');
        if (isset($serviceName)) {
            /** @var $eauth \nodge\eauth\ServiceBase */
            $eauth = Yii::$app->get('eauth')->getIdentity($serviceName);
            $returnUrl = '/dashboard';

            $return=Yii::$app->session->get('return',false);
            if($return){
                $eauth->setRedirectUrl($return);
            }else{
                $eauth->setRedirectUrl($returnUrl);
            }

            $eauth->setCancelUrl(Yii::$app->getUrlManager()->createAbsoluteUrl('auth/signup'));
            try {
                if ($eauth->authenticate()) {
                    $userInfo = $eauth->getAttributes();
                    $identity = Client::findByEAuth($eauth, $userInfo);
                    Yii::$app->user->login($identity);

                    $return=Yii::$app->session->get('return',false);
                    if($return){
                        return $this->redirect($return);
                    }

                    // special redirect with closing popup window
                    return $eauth->redirect();
                } else {
                    // close popup window and redirect to cancelUrl
                    return $eauth->cancel();
                }
            } catch (ErrorException $e) {
//                exit();
                // save error to show it later
                Yii::$app->getSession()->setFlash('error', 'EAuthException: ' . $e->getMessage());
                // close popup window and redirect to cancelUrl
                return $eauth->redirect($eauth->getCancelUrl());
            }
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }



    public function actionSignup()
    {
        $registerForm = new RegisterForm();

        $post = Yii::$app->request->post();
        if (Yii::$app->request->isAjax && $registerForm->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($registerForm);
        }
        if ($registerForm->load($post) && $registerForm->validate()) {
            if ($registerForm->register() ) {
                /***********************************
                 * ADDED SHOW TOUR AFTER 1st LOGIN *
                 ***********************************/
                /** END **/

                if(Yii::$app->request->post('return')){
                    $session = Yii::$app->session;
                    if(!$session->isActive){$session->open();}
                    $session->set('register', true);
                    return $this->redirect(Yii::$app->request->post('return'));
                }


            } else {
                Yii::$app->session->setFlash("error", "Sorry! Something went wrong!");
                return $this->redirect("/");
            }
        }

    }


    protected function redirectRegistered()
    {
        if (Yii::$app->user->id) {
//            Yii::$app->session->setFlash("success", "You are already registered. Please logout to perform this action!");
            return $this->redirect(['profile/index']);
        }
    }

    public function actionForgot()
    {
//        $this->redirectRegistered();
        $forgotPasswordForm = new ForgotPasswordForm();
        if ($forgotPasswordForm->load(Yii::$app->request->post()) && $forgotPasswordForm->validateExistingOfEmail()) {
            $forgotPasswordForm->forgotPassword();
            Yii::$app->getSession()->setFlash('success', \Yii::t("app", 'Инструкции по сбросу пароля были отправлены на вашу электронную почту'));
            return $this->redirect('/site/index');
        }else{
            Yii::$app->getSession()->setFlash('danger', \Yii::t("app", 'Пользователя с таким email не существует'));
//            return $this->redirect('/auth/forgot');
        }
        return $this->render('forgot', ['forgotPasswordForm' => $forgotPasswordForm]);
    }

    public function actionForgotPassword()
    {

        $forgotPasswordForm = new ForgotPasswordForm();
        if ($forgotPasswordForm->load(Yii::$app->request->post()) && $forgotPasswordForm->validateExistingOfEmail()) {
            $forgotPasswordForm->forgotPassword();
            Yii::$app->getSession()->setFlash('success', 'Password reset instructions have been sent to your e-mail');
        }else{
            Yii::$app->getSession()->setFlash('danger', 'Пользователя с таким email не существует');
            return $this->redirect('/auth/forgot');
        }
        return $this->redirect(['site/index']);
    }

    public function actionConfirmResetPassword()
    {
        $token=Yii::$app->request->get('token');
        $client = Client::findByPasswordResetToken($token);
        if(!$client){
            throw new HttpException('400', 'User not found');
        }
        $client->confirmResetPassword();
        Yii::$app->getSession()->setFlash('success', 'New password have been sent to your e-mail');

        $this->redirect(['site/index']);
    }
}