
<?=$this->render('@backend/views/parts/add',['title'=>'Добавить партнера', 'form'=>$this->render(Yii::$app->controller->formView,['formModel'=>$formModel])])?>