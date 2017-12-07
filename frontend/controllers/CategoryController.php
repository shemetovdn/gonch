<?php

namespace frontend\controllers;


use backend\modules\categories\models\Category;
use backend\modules\products\models\Products;
use yii\data\ActiveDataProvider;


class CategoryController extends BaseController
{
    public $sort_id = 0;

    public function actionIndex($href)
    {
        $request = \Yii::$app->request;
        if (!$href) {
            $slug = Category::find()->where(['status' => 1])->orderBy(['id' => SORT_ASC])->one()->title;
        }

        $currentCategory = Category::find()->where([ 'href' => $href])->orderBy(['id' => SORT_ASC])->one();
        $category_children = Category::getChildren([$currentCategory->id]);

        $this->sort_id = $request->get('sort');
        if(!empty($this->sort_id)){
            if($this->sort_id ==1){
                $orderBy['price'] = SORT_ASC;
            }elseif ($this->sort_id == 2){
                $orderBy['price'] = SORT_DESC;
            }
        }else{
            $orderBy['id'] = SORT_ASC;
        }

        if(!empty($category_children)){
            $query = Products::find()
                ->where(['status' => 1, 'category_id' => $category_children]);
        }else{
            $query = Products::find()
                ->where(['status' => 1, 'category_id' => $currentCategory->id]);
        }

            $dataProvider = new ActiveDataProvider([
                'query' => $query
                    ->orderBy($orderBy)
                ,
                'pagination' => [
                    'pageSize' => 12,
                ],
            ]);
            return $this->render('index', ['dataProvider' => $dataProvider, 'slug' => $href, 'model' => $currentCategory,'sort_id' => $this->sort_id]);

    }



}
