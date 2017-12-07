<?
    use yii\helpers\Html;
    use wbp\widgets\RemoveButton;
    if(!$model->status){ $bg = "background-color: #e69b9b;"; }

    $this->registerJs('
        $(document).on("change","[name=size]",function(){
            $(this).parent().parent().find(".addThisProduct").data("size",$(this).val());
            $(this).parent().parent().find(".addThisProduct").attr("data-size",$(this).val());
            
            $(this).parent().parent().find(".addThisProduct").data("size-name",$(this).find("option[value="+$(this).val()+"]").text());
            $(this).parent().parent().find(".addThisProduct").attr("data-size-name",$(this).find("option[value="+$(this).val()+"]").text());
        })
    ',\yii\web\View::POS_END,'selectChanger');
?>

<td class="center" style="<?=$bg?>"><?= $model->id ?></td>
<td style="<?=$bg?> width:80px; "><img src="<?= $model->image->getUrl('80x80') ?>" width="80" /></td>
<td style="<?=$bg?>"><?= $model->title ?></td>
<td style="<?=$bg?>">
</td>
<td width="100" class="center" style="<?=$bg?>">
    <div class="btn-group btn-actions" style="">
        <a href="#" class="btn btn-success addThisProduct" data-pjax="false" data-size-name="<?=$firstSizeName?>" data-size="<?=$firstSizeId?>" data-image="<?= $model->image->getUrl('123x123') ?>" data-price="<?=$model->price?>" data-title="<?=$model->title?>" data-id="<?=$model->id?>">
            Добавить
        </a>
    </div>
</td>

