<h4 class="pull-left"><?=$title?></h4>
<p class="btn btn-success pull-right" style="margin-bottom: 0;" data-toggle="modal" data-target="#<?=$id?>_modal">Добавить Товар</p>

<div class="clearfix"></div>
<br />

<table class="table table-hover nowrap js-table-sortable">
    <thead>
    <tr>
        <th style="width: 1%;" class="center">ID</th>
        <th>Фото</th>
        <th>Имя</th>
        <th>Кол-во</th>
        <th>Цена за ед.</th>
        <th>Всего</th>
        <th></th>

    </tr>
    </thead>
    <tbody id="<?=$id?>_block">
        <?
            $count = 0;
            foreach ($selected as $link){
                $product=$link->{$product_obj};
        ?>
                <tr>
                    <td class="center" style=""><?=$product->id?></td>
                    <td><img src="<?=$product->image->getUrl('123x123')?>" alt=""></td>
                    <td style=""><?=$product->title?></td>
                    <td style="">
                        <input type="hidden"  class="form-control prd_id"" name="Orders[<?=$field_name?>][<?=$count?>][id]" value="<?=$product->id?>">
                        <input type="number" class="form-control count" style="width:100px;" name="Orders[<?=$field_name?>][<?=$count?>][qty]" value="<?=$link->qty?>"/>
                    </td>
                    <td style="">
                        <input class="form-control price" style="width:100px;" name="Orders[<?=$field_name?>][<?=$count?>][price]" value="<?=$link->price?>"/>
                    </td>
                    <td class="total" style="line-height: 40px;">
                        0.00
                    </td>
                    <td width="100" class="center" style="">
                        <a class="btn btn-danger" href="#" data-pjax="0" onclick="$(this).parent().parent().remove();recalc();return false;"><i class="icmn-bin" aria-hidden="true"></i></a>
                    </td>
                </tr>
        <?
                $count++;
            }
        ?>
    </tbody>
</table>

<?php
    $this->registerJs('
        var count = '.$count.';
        var currency="";
        
        $(document).on("click", "#'.$id.'_modal .addThisProduct",function(e){
            var currency_id=$("#orders-currency_id").val();
            var found=false;
            e.preventDefault();
            var addButton=$(this);
            $("#'.$id.'_block").each(function(){
                if(
                    $(this).find(".prd_id[value="+addButton.data("id")+"]").length && 
                    $(this).find(".sz_id[value="+addButton.data("size")+"]").length
                ){
                   found=true;
                }
            })
            console.log(found);
            if(!found){
                var valueRow = 
                `
                    <tr>
                        <td class="center" style="">`+$(this).data("id")+`</td>
                        <td><img src="`+$(this).data("image")+`" alt=""></td>
                        <td style="">`+$(this).data("title")+`</td>
                        <td style="">
                            <input type="hidden" class="form-control prd_id" name="Orders['.$field_name.'][`+count+`][id]" value="`+$(this).data("id")+`">
                            <input  type="number" class="form-control count" style="width:100px;" name="Orders['.$field_name.'][`+count+`][qty]" value="1"/>
                        </td>
                        <td style="">
                            <input class="form-control price" style="width:100px;" name="Orders['.$field_name.'][`+count+`][price]" value="`+$(this).data("price")+`">
                        </td>
                        <td class="total" style="line-height: 40px;">
                            0.00
                        </td>
                        <td width="100" class="center" style="">
                            <a class="btn btn-danger" href="#" data-pjax="0" onclick="$(this).parent().parent().remove();recalc();return false;"><i class="icmn-bin" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                    
                `;
                $(\'#'.$id.'_block\').append(valueRow);
                count++;
            }
            recalc();
        });
    ',yii\web\View::POS_END);

    $this->registerJs('
        function recalc(){
            $("#'.$id.'_block").find("tr").each(function(){
                var price = $(this).find(".price").val();
                var count = $(this).find(".count").val();
                $(this).find(".total").html((count*price).toFixed(2));
            });
            $.pjax.reload({"container":"#totals","method": "post","history":false, "data":$("#orderForm").serialize()});
        }
        $(document).on("change", "#'.$id.'_block .count, #'.$id.'_block .price", function(){
            recalc();
        })
    ',\yii\web\View::POS_END);

    \yii\jui\Sortable::widget([
        'options' => ['id' => $id.'_block'],
        'clientOptions' => ['cursor' => 'move', 'items' => ' > .item', 'placeholder' => "sortable-placeholder pull-left item image"],
    ]);
?>

<div class="clearfix"></div>

<div class="form-actions">
    <div class="form-group row">
        <div class="col-md-9 col-md-offset-3">
            <?=\yii\helpers\Html::submitButton('Сохранить',['class'=>'btn width-150 btn-primary'])?>
            <?=\yii\helpers\Html::resetButton('Отмена',['class'=>'btn btn-default'])?>
        </div>
    </div>
</div>