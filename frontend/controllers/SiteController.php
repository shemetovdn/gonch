<?php
namespace frontend\controllers;

use backend\modules\news\models\News;
use backend\modules\pages\models\Pages;
use backend\modules\seo\models\SEO;
use backend\modules\banners\models\Banners;
use common\models\WbpActiveRecord;
use frontend\models\Contacts;
use frontend\models\Callback;
use backend\modules\discounts\models\Discounts;
use backend\modules\shares\models\Shares;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use backend\modules\products\models\Products;
use backend\modules\categories\models\Category;
use backend\modules\clients\models\Client;
use backend\modules\clients\models\ClientsForm;
use frontend\models\LoginForm;
use backend\modules\products\models\Desire;
use yii\helpers\Url;
use frontend\helpers\Transliteration;

//use yii\helpers\Html;
use frontend\models\SearchForm;


class SiteController extends BaseController
{
    public $sort_id = 0;

    public function actionSocLogin() {
        $serviceName = Yii::$app->getRequest()->getQueryParam('service');
        if (isset($serviceName)) {
            if($serviceName =="google_oauth"){
                LoginForm::GoogleLogin($serviceName);
            }
            elseif ($serviceName =="facebook"){
                LoginForm::FaceboockLogin($serviceName);
            }
        }
    }

    public function beforeAction($action)
    {
//        $this->modelSubscribe = new Subscribe(['scenario' => Subscribe::FRONTEND_SUBSCRIBE]);
//        $this->modelSubscribe->return = $_SERVER['REQUEST_URI'];

        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    public function actionIndex()
    {

        $month=Yii::$app->request->post('month',false);
        $year=Yii::$app->request->post('year',false);

        $model=Pages::findByHref('index')->one();
        SEO::setByModel($model);

        $news = new ActiveDataProvider([
            'query' => News::find()
                ->where(['status'=>1])
                ->andWhere(['<=', 'date', new Expression('NOW()')])
                ->orderBy('date DESC')
                ->limit(3),
            'pagination' => false
        ]);

        $discounts = new ActiveDataProvider([
            'query' => Discounts::find()
                ->where(['status'=>1])
                ->andWhere(['<=', 'date', new Expression('NOW()')])
            ,
            'pagination' => false
        ]);

        $products_slider = new ActiveDataProvider([
        'query' => Products::find()->where(['status'=>1, 'in_home'=>1])->orderBy("date DESC")
            ,
        'pagination' => false
    ]);
        $recommended = new ActiveDataProvider([
            'query' => Products::find()->where(['status'=>1, 'recommended_home'=>1])->orderBy("date DESC"),
            'pagination' => false
        ]);

        $query = Products::find();
        $where = array(
            'status' => 1
        );
        $query = $query->where($where);
        $session = Yii::$app->session;
        if(!$session->isActive){$session->open();}
        $viewed = $session->get('viewed');
        if(!empty($viewed)){
            $query->andWhere(['in', 'id', $viewed]);
        }else{
            $query->andWhere(['in', 'id', -1]);
        }
        $home_products = new ActiveDataProvider([
            'query' => Products::find()->where(['status'=>1, 'category_id'=> \common\models\Config::getParameter('category_id')])
                ->limit(3)->orderBy("date DESC"),
            'pagination' => false
        ]);
        $categoryInHome = Category::findOne(\common\models\Config::getParameter('category_id'));

        $viewed = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);

        $shares = new ActiveDataProvider([
            'query' => Shares::find()
                ->where(['status'=>1])
                ->andWhere(['<=', 'date', new Expression('NOW()')])
            ,
            'pagination' => false
        ]);
        $main_banner = Banners::findOne(5);

        return $this->render('index', [
            'month'=>$month,
            'year'=>$year,
            'model'=>$model,
            'news'=>$news,
            'main_banner'=>$main_banner,
            'discounts'=>$discounts,
            'shares'=>$shares,
            'products_slider' => $products_slider,
            'recommended' => $recommended,
            'viewed' => $viewed,
            'home_products' => $home_products,
            'categoryInHome' => $categoryInHome
        ]);
    }

    public function actionGenericPage($href)
    {
        $this->page = Pages::findByHref($href)->one();
        $actionName = 'action' . str_replace(' ', '', ucwords(strtolower(str_replace('-', ' ', $href))));
        if (method_exists($this, $actionName)) return call_user_func([$this, $actionName], $this->page);

        $view_file = $this->getViewPath($href) . DIRECTORY_SEPARATOR . $href . ".php";
        if (file_exists($view_file)) return $this->render($href, ['model' => $this->page]);

        if (!$this->page) {
            throw new NotFoundHttpException('Page "' . $href . '" not found ', 404);
        }
        $parent = false;
        if ($this->page->parent_page > 0) {
            $parent = Pages::findOne(['id' => $this->page->parent_page, 'status' => WbpActiveRecord::STATUS_ACTIVE]);
        }
        return $this->render('generic-page', ['model' => $this->page, 'parent' => $parent]);
    }

    public function actionError()
    {
        $this->redirect(['index']);
        Yii::$app->end();
    }

    public function actionContact()
    {
        $model=Pages::findByHref('contacts')->one();
        SEO::setByModel($model);

        $contact = new Contacts(['scenario' => Contacts::FRONTEND_ADD_SCENARIO]);
        if ($contact->load(Yii::$app->request->post())) {

            if ($contact->save()) {
                \Yii::$app->session->setFlash('success', 'Спасибо, мы свяжемся с Вами в течение 48 часов.');
                return $this->redirect(['site/contact']);
            } else {
                \Yii::$app->session->setFlash('error',  'Что-то не так, пожалуйста, заполните все поля и отправьте еще раз.');
            }
        }

        return $this->render('contact', ['model' => $model, 'contact' => $contact]);
    }



    public function actionSubscribe()
    {
        if ($this->modelSubscribe->load(\Yii::$app->request->post())
            && $this->modelSubscribe->validate()
        ) {
            $this->modelSubscribe->save();
            $model=$this->modelSubscribe;
            $message= \yii::t('app', 'Спасибо за то что подписались')." ";
            Yii::$app->session->setFlash('success', $message);
            return $this->redirect($this->modelSubscribe->return);
        }else{
            Yii::$app->session->setFlash('error',  'Что-то не так, пожалуйста, заполните все поля и отправьте еще раз.');

        }
        return $this->redirect([$this->modelSubscribe->return]);
    }

    public function actionUnsubscribe($email, $hash)
    {
        $model = Subscribe::find()
            ->where([
                'email' => $email,
                'hash' => $hash,
            ])
            ->one();
        if ($model) {
            $model->status = WbpActiveRecord::STATUS_DISABLED;
            $model->save();
            \Yii::$app->session->setFlash('success', \yii::t('app', 'You are unsubscribed').'.');
        }
        return $this->redirect(['site/index']);
    }

    public function actionCallback(){
        $contact = new Callback(['scenario' => Callback::FRONTEND_ADD_SCENARIO]);
        if ($contact->load(Yii::$app->request->post())) {
            if ($contact->validate() && $contact->save()) {
                Yii::$app->session->setFlash('success', \Yii::t('app','Спасибо, мы свяжемся с вами в ближайшее время'));
                $this->redirect([Url::previous()]);
                Yii::$app->end();
            } else {
                Yii::$app->session->setFlash('error',  \Yii::t('app', 'Что-то не так, пожалуйста, заполните все поля и отправьте еще раз'));
            }

        }
        return $this->redirect([Url::previous()]);
    }

    public function actionOrder()
    {
        $this->layout = 'empty';
        $model = new Orders(['scenario' => Orders::FRONTEND_ADD_SCENARIO]);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->save()) {
                \Yii::$app->session->setFlash('success', 'Спасибо, мы свяжемся с вами через 48 часов');
                return $this->redirect($model->return);
            } else {
                \Yii::$app->session->setFlash('error',  \Yii::t('app', 'Что-то не так, пожалуйста, заполните все поля и отправьте еще раз'));
            }
        }
        return $this->render('order', ['model'=>$model]);
    }
    public function actionAddToCart(){
        $request = Yii::$app->request;
        $session = Yii::$app->session;

        if($request->isAjax){
            $id = $request->post('id');
            $price = $request->post('price');
            if(!$session->isActive){$session->open();}
            $cart = $session->get('cart');
if(is_array($cart)){
    if (empty($cart[$id])) {
        $cart[$id] = array(
            'qty' => 1,
            'price' => $price
        );
        $session->set('cart', $cart);
        return count($cart);
    }else{
        return 0;
    }
} else{
    $cart[$id] = array(
        'qty' => 1,
        'price' => $price
    );
    $session->set('cart', $cart);
    return  count($cart);
}

        }
    }

    public function actionRemoveFromCart(){
        $request = Yii::$app->request;
        $session = Yii::$app->session;

        if($request->isAjax){
            $id = $request->post('id');
            if(!$session->isActive){$session->open();}
            $cart = $session->get('cart');
            $key = array_search($id, $cart);
            if(!empty($cart[$key])){
                unset($cart[$key]);
                $session->set('cart', $cart);
                return count($cart);
            }
        }
    }

    public function actionCart()
    {

        $request = Yii::$app->request;
        $session = Yii::$app->session;

        if($request->isAjax){
            $id = $request->post('id');
            if(!$session->isActive){$session->open();}
            $cart = $session->get('cart');
            if(!empty($cart[$id])){
                unset($cart[$id]);
                $session->set('cart', $cart);
            }
        }


        $query = Products::find();
        $where = array(
            'status' => 1
        );
        $query = $query->where($where);
        $session = Yii::$app->session;
        if(!$session->isActive){$session->open();}
        $cart = $session->get('cart');
        if(is_array($cart)){$cart = array_keys($cart);}
        if(!empty($cart)){
            $query->andWhere(['in', 'id', $cart]);
        }else{
            $query->andWhere(['in', 'id', -1]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);

        return $this->render('cart', ['dataProvider' => $dataProvider, 'totalAmount' => $this->cartTotal]);
    }

    public function actionAddToWishlist(){
        $request = Yii::$app->request;


        if($request->isAjax){
            $product_id= $request->post('product_id');
            $user_id= $request->post('user_id');
            $product = Desire::find()
                        ->where([
                            "product_id" => $product_id,
                            "user_id"=> $user_id])
                        ->one();

            if(!empty($product)){
                return 0;
            }else{
                $prod = new Desire();
                $prod->user_id = $user_id;
                $prod->product_id = $product_id;
                if($prod->save()){
                    return 1;
                }
            }
        }
    }

    public function actionChangeAmount(){
        $request = Yii::$app->request;
        if($request->isAjax){
            $product_id= $request->post('product_id');
            $price = $request->post('price');
            $qty= $request->post('qty');

            $session = Yii::$app->session;
            if(!$session->isActive){$session->open();}
            $cart = $session->get('cart');

            if(is_array($cart)){
                    $cart[$product_id]['qty'] =  $qty;

                    $session->set('cart', $cart);
                    return 1;

            } else{
                $cart[$product_id] = array(
                    'qty' => $qty,
                    'price' => $price,
                );
                $session->set('cart', $cart);
                return 1;
            }
        }
    }

    public function actionSearch(){

        $model = new SearchForm();
        if($model->load(Yii::$app->request->post()) && $model->validate()){

            $q = Html::encode($model->q);

            $request = Yii::$app->request;
            $this->sort_id = $request->post('id');

            if(!empty($this->sort_id)){
                if($this->sort_id ==1){
                    $orderBy['price'] = SORT_ASC;
                }elseif ($this->sort_id == 2){
                    $orderBy['price'] = SORT_DESC;
                }
            }else{
                $orderBy['id'] = SORT_ASC;
            }


            $dataProvider = new ActiveDataProvider([
                'query' => Products::find()->where(['like', 'title', $q])->orderBy($orderBy),
                'pagination' => [
                    'pageSize' => 12,
                ],
            ]);

            return $this->render('search', [
                'dataProvider' => $dataProvider,
                'request' => $q,
                'allrequest' => Yii::$app->request->post()
            ]);

//            return $this->redirect();
        }else{
            \Yii::$app->session->setFlash('error',  \Yii::t('app','Уточните параметры поиска'));

        }

        return $this->redirect(['site/index']);
    }

    public function actionWishlistBeforeLogin(){
        $request = Yii::$app->request;
        $session = Yii::$app->session;

        if($request->isAjax){
            $id = $request->post('product_id');
            if(!$session->isActive){$session->open();}
            $wishlist = $session->get('wishlist');
            if(is_array($wishlist)){
                if (!in_array($id, $wishlist)) {
                    $wishlist[] = $id;
                    $session->set('wishlist', $wishlist);
                    return 1;
                }else{
                    return 0;
                }
            } else{
                $wishlist[] = $id;
                $session->set('wishlist', $wishlist);
                return 1;
            }

        }
    }

    public function actionGetCartTotal(){
        $request = Yii::$app->request;
        if($request->isAjax){
        return $this->cartTotal;
        }
    }

    public function actionToggleReturn(){
        $request = Yii::$app->request;
        if($request->isAjax){
            $return = $request->post('return');
            $session = Yii::$app->session;
            if(!$session->isActive){$session->open();}
            if($return == 0){
                $session->remove('return');
            }else{
                $session->set('return', true);
            }
        }
    }


    public function actionCompany()
    {
        $model=Pages::findByHref('company')->one();
        SEO::setByModel($model);

        return $this->render('generic-page',['model'=>$model]);
    }

    public function actionDostavkaIOplata()
    {
        $model=Pages::findByHref('dostavka-i-oplata')->one();
        if(!$model){
            throw new NotFoundHttpException("Page Not Found.", 404);
        }
        SEO::setByModel($model);

        return $this->render('generic-page',['model'=>$model]);
    }
    public function actionObmenIVozvrat()
    {
        $model=Pages::findByHref('obmen-i-vozvrat')->one();
        if(!$model){
            throw new NotFoundHttpException("Page Not Found.", 404);
        }
        SEO::setByModel($model);

        return $this->render('generic-page',['model'=>$model]);
    }
    public function actionOferta()
    {
        $model=Pages::findByHref('oferta')->one();
        if(!$model){
            throw new NotFoundHttpException("Page Not Found.", 404);
        }
        SEO::setByModel($model);

        return $this->render('generic-page',['model'=>$model]);
    }

}
