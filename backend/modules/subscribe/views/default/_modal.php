<?php
/**
 * Created by PhpStorm.
 ** User: Леха alexeymarkov.x7@gmail.com
 *** Date: 01.03.2016
 **** Time: 12:00
 */
use yii\helpers\Html;
use yii\helpers\Url;

$uCKid = uniqid('ck_');
?>

    <div class="" id="myModal" style="display: block;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="bootbox-close-button close" data-dismiss="modal" aria-hidden="true"
                            onclick="uniqueOverlay.close();">×
                    </button>
                    <h4 class="modal-title">Message # <?= $model->id ?> ( <?=Yii::$app->formatter->asDatetime($model->created_at)?> )</h4>
                </div>
                <?
                $form = \yii\widgets\ActiveForm::begin([
                    'id' => 'form-' . $uCKid,
                    'action' => Url::to(['create-answer']),

                ]);
                ?>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <td class="col-md-2"><b>Email</b>:</td>
                            <td class="col-md-offset-3 col-md-3"><?= Html::encode($model->email) ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-12">

                    <?= $form->field($model, 'id')->hiddenInput()->label(false); ?>

                    <?= $form->field($formModel, 'answer')
                        ->textarea([
                            'id' => $uCKid,
                            'class' => 'form-control',
                            'rows' => '5',
                            'style' => 'resize: none;'
                        ])->label('Answer') ?>
                </div>
                <div class="modal-footer">
                    <?
                    echo \yii\helpers\Html::submitButton('Reply', ['class' => 'btn btn-primary']);

                    echo \yii\helpers\Html::Button('Close', ['class' => 'btn btn-default', 'onclick' => 'uniqueOverlay.close();']);
                    ?>
                </div>
                <?
                \yii\widgets\ActiveForm::end();
                ?>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<?php
echo \wbp\uniqueOverlay\UniqueOverlay::script();