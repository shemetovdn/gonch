<?php
namespace backend\modules\regions\models;

use common\models\WbpActiveRecord;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/**
 * Class Sweepstakes
 * @package backend\modules\sweepstakes\models
 */
class Regions extends WbpActiveRecord
{

    public static $imageTypes = ['Regions'];

    public static function tableName()
    {
        return '{{%regions}}';
    }

    public function rules()
    {
        return [
            [['title', 'status', 'sort'], 'safe', 'on' => [WbpActiveRecord::ADMIN_ADD_SCENARIO, WbpActiveRecord::ADMIN_EDIT_SCENARIO]],
            [['title', 'status',], 'required', 'on' => [WbpActiveRecord::ADMIN_ADD_SCENARIO, WbpActiveRecord::ADMIN_EDIT_SCENARIO]],
        ];
    }

    public function getDescription($symbols = 150)
    {
        $out = $this->description;
        if ($this->short_description) {
            $out = $this->short_description;
        }


        return StringHelper::truncate($out, $symbols);
    }

    public static function findByHref($href)
    {
        return self::find()
            ->where(['href' => $href]);
    }

    public static function findById($id)
    {
        return self::find()->where(['id' => $id])->one();
    }

    public static function findByMonthYearDay($month,$year,$day){
        $month=sprintf("%02d",$month);
        $day=sprintf("%02d",$day);
        $startDate=$year.'-'.$month.'-'.$day.' 00:00:00';
        $stopDate=$year.'-'.$month.'-'.$day.' 23:59:59';
        return self::find()->Where(['status'=>'1'])->andWhere(['>=','date',$startDate])->andWhere(['<=','date',$stopDate]);
    }

    public function getUrl(){
        return Url::to(['regions/view', 'href'=>$this->href]);
    }

    public function beforeSave($insert)
    {
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function attributeLabels()
    {
        return [
            'title'         => 'Название',
            'status'        => \Yii::t('admin', 'status'),
        ];
    }

}