<?php
/**
 * Created by PhpStorm.
 * User: Maksim Sergeevich (doctorpepper608@gmail.com)
 * Date: 25.02.2016
 * Time: 10:58
 */

namespace frontend\controllers;

use backend\modules\discounts\models\Discounts;
use backend\modules\pages\models\Pages;
use backend\modules\seo\models\SEO;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\db\Expression;

class DiscountsController extends BaseController
{

    public function actionIndex()
    {
        $dataProvider=new ActiveDataProvider([
            'query'=>Discounts::find()
                ->where(['status'=>1])
                ->andWhere(['<=', 'date', new Expression('NOW()')])
            ,
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
        $model=Discounts::findByHref($href)->one();

        $dataProvider=new ActiveDataProvider([
            'query'=>Discounts::find()->where(['status'=>1])->andWhere(['!=', 'id', $model->id])->andWhere(['<=', 'date', new Expression('NOW()')]),
            'pagination' => [
                'pageSize' => 3,
            ],
        ]);
        return $this->render('view', ['dataProvider' => $dataProvider, 'article' => $model]);
    }

}