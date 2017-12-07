
<?=$this->render('@backend/views/parts/add',['title'=>Yii::t('admin','Добавить скидку'), 'form'=>$this->render(Yii::$app->controller->formView,['formModel'=>$formModel])])?>