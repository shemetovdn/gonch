<?php
namespace backend\modules\categories\models;

use yii\base\Object;

class MenuSort extends Object
{
    public $data;

    public $prefix = '';

    protected function getPath($category_id, $prefix = false)
    {
        foreach ($this->data as $item) {
            if ($category_id == $item['id']) {
                $prefix = $prefix ? $this->prefix . $prefix : $item['title'];
                if ($item['parent_id']) {
                    return $this->getPath($item['parent_id'], $prefix);
                } else {
                    return $prefix;
                }
            }
        }
        return '';
    }

    public function getList($parent_id = 0)
    {
        $data = [];
        $deep = 0;
        foreach ($this->data as $item) {
            if ($parent_id == $item['parent_id']) {
                $data[] = [
                    'id' => $item['id'],
                    'title' => $item['title'],
                    'href' => $item['href'],
                    'deep' => $parent_id."|".$deep
                ];
                $data = array_merge($data, $this->getList($item['id']));

            }else{
                $deep++;
            }
        }
        return $data;
    }
}