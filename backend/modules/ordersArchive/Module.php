<?php
namespace backend\modules\ordersArchive;

class Module extends \yii\base\Module
{
    public $controllerNamespace;

    public $text = [
        'add_item' => 'Добавить Заказ',
        'module_name' => 'Архив заказов',
        'edit_item' => 'Изменить заказ',
        'remove_item' => 'Удалить',
        'remove_confirmation' => 'Вы уверены что хотите удалить заказ',
        'module_manage' => 'Управление Заказами',
        'total_items' => 'Всего Заказов',
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
