<?=$this->render(
    '@backend/views/parts/edit',
    [
        'title'=>Yii::t('admin', Yii::$app->controller->module->text['edit_item']),
        'form'=>$this->render(Yii::$app->controller->formView,['formModel'=>$formModel]),
        'add'=>Yii::$app->controller->module->text['add_item'],          // Add "Add button"
        'delete'=>(true)?$formModel->id:false,                                                 // Add Remove Button
    ])
?>
