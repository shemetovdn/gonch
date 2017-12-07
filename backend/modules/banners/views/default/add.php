
<?=$this->render('@backend/views/parts/add',['title'=>Yii::t('admin','Добавить баннер'), 'form'=>$this->render(Yii::$app->controller->formView,['formModel'=>$formModel])])?>