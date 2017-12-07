<?php
namespace backend\modules\categories\models;

use backend\modules\products\models\Product;
use common\models\WbpActiveRecord;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\modules\parametrs\models\Parametrs;
use creocoder\nestedsets\NestedSetsBehavior;
use backend\modules\categories\models\CategoryParametrs;

class Category extends WbpActiveRecord
{
    public static $seoKey = 'category';
    public static $imageTypes = ['category', 'menuIcon'];
    public static $fileTypes = ['category'];
    protected $arrayPars=['params_ids'];
    public $params;

    public static function tableName()
    {
        return '{{%categories}}';
    }

    public function rules()
    {
        return [
            [['title',
                'href',
                'status',
                'description',
                'description_ua',
                'subtitle',
                'subtitle_ua',
                'parent_id',
                'title_ua',
                'params_ids',
                'depth'
            ], 'safe', 'on' => [self::ADMIN_ADD_SCENARIO, self::ADMIN_EDIT_SCENARIO]],
        ];
    }

    public function getUrl($absolute = false)
    {
        return Url::to(['catalog/'.$this->href]);
    }



    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['category_id' => 'id']);
    }

    public function getParametrs()
    {
        $params = Parametrs::find()->where(['id' => $this->params_ids, 'status' => 1])->all();

        return $params;
    }

    public function getRootProductsDataProvider()
    {
        return new ActiveDataProvider([
            'query' => Product::find()->where([
                'status' => 1,
                'category_id' => $this->id,
                'parent' => 0,
            ])
                ->orderBy(['sort' => SORT_ASC])
        ]);
    }

    public static function getParentCategoryForMenu(){
        $row = \backend\modules\categories\models\Category::find()->where(['status' => 1,'parent_id' => 0])->all();
        $categories =array();

        foreach($row as $key => $category){
            $title = $category->getMultiLang('title');
            if(empty($title)){
                $title = $category->title;
            }

            $categories[] = [
                'label' => $title,
                'url' => Url::to("/category/".$category->href),
//                'items'=>$category['items'],
//                'template' => '<a class="dropdown-toggle" data-toggle="dropdown" href="{url}" role="button" aria-haspopup="true" >{label}<span class="carett"></span></a>',
                'options' => [
//                    'class'=>'dropdown dropdown1',
                ],
            ];
        }

        return $categories;
    }

    public static function getCategoryForMenu(){
        $row = \backend\modules\categories\models\Category::find()
            ->select(['id', 'parent_id', 'title', 'title_ua', 'href', 'depth'])
            ->orderBy('depth, parent_id  ASC')
//            ->asArray()
            ->all();
        $categories =array();
        $arr_cat = array();
        foreach($row as $key => $value){
            $arr_cat[$value->parent_id][] = $value;
        }

        foreach ($arr_cat as $group_key => $cat_group){

            foreach ($cat_group as $cat_key => $cat){
//    var_dump($cat->getMultiLang('title'));exit;
                $cat->image->id ? $icon='<span class="icon_cat" style="background-image: url('.$cat->image->getUrl().');"></span>' : $icon='';
                if($group_key == 0){
                    $categories[$cat['id']] = array(
                        'title' => $cat->getMultiLang('title'),
                        'id' => $cat['id'],
//                        'icon' => $cat->file->getUrl(),
                        'icon' => $icon,
                        'parent_id' => $cat['parent_id'],
                        'url' => ['/category/index','href'=>$cat['href']],
                        'items' => array()
                    );
                }else{
                    if(!empty($categories[$cat['parent_id']])){
                        $categories[$cat['parent_id']]['items'][$cat['id']] = array(
                            'label' => $cat->getMultiLang('title'),
                            'id' => $cat['id'],
                            'depth' => $cat['depth'],
                            'parent_id' => $cat['parent_id'],
                            'url' => ['/category/index','href'=>$cat['href']],
                            'items' => array(),
                            'submenuTemplate' => "\n<ul class='dropdown-menu collapse custom-1 custom-2'>\n{items}\n</ul>\n",
                            'template' => '<a  href="{url}" class="dropdown-toggle" data-toggle="dropdown" role="button" data-target="#dropdown2" aria-haspopup="true" aria-expanded="false">{label}<span class="carett carett-2"></span></a>',
                            'options' => [
                                'class'=>'dropdown dropdown2',
                            ],
                        );

                    }else{
                        $parent_cat = Category::findOne($cat['parent_id']);
                        if($parent_cat->parent_id != 0){
                            $categories[$parent_cat->parent_id]['items'][$cat['parent_id']]['items'][$cat['id']] = array(
                                'label' => $cat->getMultiLang('title'),
                                'id' => $cat['id'],
                                'depth' => $cat['depth'],
                                'parent_id' => $cat['parent_id'],
                                'url' => ['/category/index','href'=>$cat['href']],
                                'items' => array(),
//                                'template' => '<a class="dropdown-toggle" data-toggle="dropdown" role="button" data-target="#dropdown2" aria-haspopup="true" aria-expanded="false">{label}</a>',
                                'options' => [
                                    'class'=>'dropdown dropdown2',
                                ],
                            );
                        }
                    }
                }
            }


        }
        return $categories;
    }

    public static function Breadcrumbs($id){

        $categories_arr = array_reverse(self::BreadcrumbsBild($id));
        $categories = array();

        foreach ($categories_arr as $key =>$value){
            $categories[] = array(
                'template' => "<li><b>{link}</b></li>\n", //  шаблон для этой ссылки
                'label' => $value->getMultiLang('title'), // название ссылки
                'url' => ['/category/'.$value->href] // сама ссылка
            );
        }



        return $categories;
    }

    public static function BreadcrumbsBild($id, $breadcrumbs_arr = array()){

        $category = Category::find()->where(['id' => $id])->one();

        $breadcrumbs_arr[] = $category;
        if($category->parent_id != 0){
           return Category::BreadcrumbsBild($category->parent_id, $breadcrumbs_arr);
        }else{
            return $breadcrumbs_arr;
        }

    }

    public static function getChildren($children = array(), $ids = array()){
            $children = Category::find()
                ->select('id')
                ->where(['parent_id' => $children])
                ->asArray()
                ->all();
        $children_array = array();
        foreach($children as $key=>$value){   $children_array[] = $value['id'];}
        $ids = array_merge ($ids, $children_array);
            if(!empty($children)){
                return Category::getChildren($children_array, $ids);
            }else{
                return $ids;
            }
    }

    public function getCategoryParametrs(){
        return $this->hasMany(CategoryParametrs::className(), ['category_id' => 'id'])->orderBy('id');
    }


    public function afterSave($insert, $changedAttributes)
    {
        $parametrs = \Yii::$app->request->post("Category")["params_ids"];
        $param_del = CategoryParametrs::find()->where(['category_id'=>$this->id])->all();
        foreach($param_del as $param){
            $param->delete();
        }
        if(!empty($parametrs)){
            foreach ($parametrs as $key=>$value){
                $params = new CategoryParametrs();
                $params ->parametr_id = $value;
                $params ->category_id = $this->id;
                $params->save();
            }
        }

        return parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

}