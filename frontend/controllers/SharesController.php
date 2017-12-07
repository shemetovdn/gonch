<?php
/**
 * Created by PhpStorm.
 * User: Maksim Sergeevich (doctorpepper608@gmail.com)
 * Date: 25.02.2016
 * Time: 10:58
 */

namespace frontend\controllers;

use backend\modules\shares\models\Shares;
use backend\modules\pages\models\Pages;
use backend\modules\seo\models\SEO;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\db\Expression;

class SharesController extends BaseController
{

    public function actionIndex()
    {
        $model=Pages::findByHref('news')->one();
        SEO::setByModel($model);

        $dataProvider=new ActiveDataProvider([
            'query'=>Shares::find()
                ->where(['status'=>1])
                ->andWhere(['<=', 'date', new Expression('NOW()')])
            ,
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);

        return $this->render('index', ['dataProvider' => $dataProvider,'model'=>$model]);
    }

    public function actionView($href)
    {
        $model=Shares::findByHref($href)->one();

        $dataProvider=new ActiveDataProvider([
            'query'=>Shares::find()
                ->where(['status'=>1])
                ->andWhere(['<=', 'date', new Expression('NOW()')])
                ->andWhere(['!=', 'id', $model->id]),
            'pagination' => [
                'pageSize' => 3,
            ],
        ]);
        return $this->render('view', ['dataProvider' => $dataProvider, 'article' => $model]);
    }

}