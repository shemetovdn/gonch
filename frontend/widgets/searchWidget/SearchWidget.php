<?php

namespace frontend\widgets\searchWidget;

use frontend\models\SearchForm;


class SearchWidget extends \yii\base\Widget {

    public function run()
    {
        $model = new SearchForm();
        return $this->render('widget', ['model' => $model]);
    }
}