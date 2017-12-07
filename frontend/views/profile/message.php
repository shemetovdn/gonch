<?php
    $this->registerJs('hideAjaxerMask();');
//    echo \wbp\PrettyAlert\Alert::widget(["autoSearchInSession"=>true]);
?>

<?
$errors = \Yii::$app->session->getAllFlashes();
if(count($errors)> 0){
    foreach ($errors as $type => $message) {
        $uniqId=uniqid('modal_');
        ?>
        <!-- Modal -->
        <div class="modal fade modal-thank-you" id="<?=$uniqId?>" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="tex-1"><?=\common\models\Config::getParameter('title')?></div>
                        <div class="tex-1 tex-2"><?=$message?></div>
                    </div>
                    <div class="modal-footer">
                        <a data-dismiss="modal" class="btn-1">Close</a>
                    </div>
                </div>
            </div>
        </div>

        <?
        $this->registerJs("$('#{$uniqId}').modal('show');",\yii\web\View::POS_READY);
    }
}
?>

