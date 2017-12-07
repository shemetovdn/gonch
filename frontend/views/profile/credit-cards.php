<?php
    use yii\widgets\ListView;
    \wbp\ajaxer\AjaxerAsset::register($this);

    $this->registerJs('
        function addCard(){
            showAjaxerMask();
            $.ajax({
                url: "'.\yii\helpers\Url::to(['/profile/add-card']).'",
                success: function(){
                    $.pjax.reload("#cardsNew", {timeout: 10000});
                }
            })
        }
        jQuery(document).on("pjax:success", "#cardsNew",  function(event){
            hideAjaxerMask();
        });
    ', \yii\web\View::POS_END);

?>


<div class="modal fade modal-thank-you" id="terms" tabindex="-1" role="dialog" aria-labelledby="LoginLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a type="button" class="close" data-dismiss="modal" aria-hidden="true">×</a>
            </div>
            <div class="modal-body" style="padding-left: 15px;padding-right: 15px;">
                <div class="tex-1">Terms & Conditions</div>
                <div class="tex-2" style="color: #fff;">
<!--                    --><?//=\backend\modules\pages\models\Pages::findByHref('terms-and-conditions')->one()->contents[0]?>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn-1 btn-2" onclick='$("#terms").modal("hide");return false;'>Close</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="loginpadding newmyacc">
    <div class="log cards">CREDIT CARDS</div>
    <div class="clearfix"></div>
    <div class="redline"></div>

    <?

    \yii\widgets\Pjax::begin(['id'=>'cardsNew', 'timeout' => 5000, 'linkSelector'=>'.pjax-link', 'clientOptions'=>['url'=>\yii\helpers\Url::to(['/dashboard-profile/credit-cards'])]])?>
    <a href="#" style="margin-bottom: -25px;" class="sign addcard" data-pjax="false" onclick="addCard(); return false;">ADD CARD</a>
    <div class="clearfix"></div>


    <?=ListView::widget([
        'dataProvider'=>new \yii\data\ActiveDataProvider(['query'=>$cards,'pagination'=>false, 'key'=>NULL]),
        'layout'=>'{items}',
        'itemView'=>function($model,$key, $index, $widget){
            $model->scenario=\backend\modules\clients\models\ClientCreditCard::CreateFrontendScenario;
            return $this->render('credit-cards-item',['model'=>$model,'key'=>$key, 'index'=>$index]);
        },
        'emptyText'=>'<center style="line-height: 50px;margin-top: 15px;">No credit cards found.</center>'
    ])?>
    <? \yii\widgets\Pjax::end() ?>




    <form>

    </form>
</div>
