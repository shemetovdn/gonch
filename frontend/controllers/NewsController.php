<?php
namespace frontend\controllers;

use backend\modules\news\models\News;
use backend\modules\pages\models\Pages;
use backend\modules\seo\models\SEO;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\db\Expression;

class NewsController extends BaseController
{

    public function actionIndex()
    {

        $dataProvider=new ActiveDataProvider([
            'query'=>News::find()
                ->where(['status'=>1])
                ->andWhere(['<=', 'date', new Expression('NOW()')])
                ->orderBy('date DESC'),
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);
        $model=Pages::findByHref('news')->one();
        SEO::setByModel($model);

        return $this->render('index', ['dataProvider' => $dataProvider,'model'=>$model]);
    }

    public function actionView($href)
    {
        $article=News::findByHref($href)->one();

        $dataProvider=new ActiveDataProvider([
            'query'=>News::find()->where(['status'=>1])
                ->andWhere(['<=', 'date', new Expression('NOW()')])
                ->andWhere(['!=', 'id', $article->id])
            ,
            'pagination' => [
                'pageSize' => 3,
            ],
        ]);
        return $this->render('view', ['dataProvider' => $dataProvider, 'article' => $article]);
    }

}