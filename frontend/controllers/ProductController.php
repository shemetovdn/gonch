<?php

namespace frontend\controllers;


use backend\modules\categories\models\Category;
use backend\modules\products\models\Products;
use backend\models\Images;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use backend\modules\products\models\Associated;
use Yii;

class ProductController extends BaseController
{

    public function actionIndex($id)
    {
        if (!$id) {

        }else{
            $product = Products::findOne($id);
            $product_images = Images::find()
                ->select(' id, ext')
                ->where(['item_id'=>$id])
                ->asArray()
                ->all();
            return $this->render('product', ['model'=> $product, 'product_images'=>$product_images]);
        }
    }
    public function actionView($href)
    {
        $model=Products::findOne(['href' => $href]);
        if(!$model){$model=Products::findOne(['id' => $href]);}
        if(!$model) throw new NotFoundHttpException('Page not fount.');
        $recommended = new ActiveDataProvider([
            'query' => Products::find()->where(['status'=>1, 'category_id'=> $model->category_id, 'recommended' => 1])
                ->andWhere(['!=', 'id', $model->id])
                ->limit(3)
                    ,
            'pagination' => false
        ]);
        $assoc_array = Associated::find()
                        ->where(["product_id" => $model->id])
                        ->asArray()
                        ->all();
        $assoc_where = array();
        foreach ($assoc_array as $key => $value){
            $assoc_where[] = $value["associated_id"];
        }

//echo "<pre>";var_dump($assoc_where);exit;

        $associated = new ActiveDataProvider([
            'query' => Products::find()
                ->where(['status'=>1, 'id'=> $assoc_where])
                ->andWhere(['!=', 'id', $model->id])
                ->orderBy("date DESC")
                ->limit(3)
            ,
            'pagination' => false
        ]);
//        echo "<pre>";var_dump($associated);exit;
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

        $viewed_product = new ActiveDataProvider([
            'query' => $query->orderBy("date DESC"),
            'pagination' => false
        ]);


        return $this->render('view', [
            'model'=>$model,
            'recommended' => $recommended,
            'viewed_product' => $viewed_product,
            'associated' => $associated,
            ]);
    }

}
