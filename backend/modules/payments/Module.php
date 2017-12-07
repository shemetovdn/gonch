<?php
namespace backend\modules\payments;

class Module extends \yii\base\Module
{
    public $controllerNamespace;

    public $text = [
        'add_item' => 'Добавить Платеж',
        'module_name' => 'Платежи',
        'edit_item' => 'Изменить платеж',
        'remove_item' => 'Удалить',
        'remove_confirmation' => 'Вы уверены что хотите удалить платеж',
        'module_manage' => 'Управление Платежами',
        'total_items' => 'Всего платежей',
    ];

    public $actions;

    public static $module_actions = [
        'enable_add' => true,
        'enable_edit' => true,
        'enable_delete' => true,
        'enable_view' => true,
    ];

    public function init()
    {
        $this->actions=self::$module_actions;
        $tmp = explode(DIRECTORY_SEPARATOR, __DIR__);
        $tmp = $tmp[count($tmp) - 1];
        $this->controllerNamespace = 'backend\modules\\' . $tmp . '\controllers';

        parent::init();
    }
}
