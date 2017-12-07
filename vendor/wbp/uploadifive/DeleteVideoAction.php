<?php

namespace wbp\uploadifive;

use wbp\video\Video;
use Yii;

class DeleteVideoAction extends \yii\base\Action {

    public function run() {

        $id=(int)Yii::$app->getRequest()->post('id');

        $video=Video::findOne($id);
        if($video->id){
            $video->delete();
        }

    }


}
