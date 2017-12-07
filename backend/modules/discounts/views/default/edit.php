<?
use yii\helpers\Html;

echo $this->render(
    '@backend/views/parts/edit',
    [
        'title'=>'Редактировать скидку '.Html::encode($formModel->title),
        'form'=>$this->render(Yii::$app->controller->formView,['formModel'=>$formModel]),
        'add'=>(true)?'Добавить скидку':false,          // Add "Add button"
        'delete'=>(true)?$formModel->id:false,                                                 // Add Remove Button
    ])
?>
