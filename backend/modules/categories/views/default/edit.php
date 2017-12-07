<?
use yii\helpers\Html;

echo $this->render(
    '@backend/views/parts/edit',
    [
        'title'=>'Редактировать Категорию '.Html::encode($formModel->title),
        'form'=>$this->render(Yii::$app->controller->formView,['formModel'=>$formModel]),
        'add'=>(true)?'Добавить Категорию':false,          // Add "Add button"
        'delete'=>(true)?$formModel->id:false,                                                 // Add Remove Button
    ])
?>
