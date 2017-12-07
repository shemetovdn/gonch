<?
    \yii\widgets\Pjax::begin(['id'=>'filter-'.$filter->id]);
?>
<div class="form-group row">
    <div class="col-md-3">
        <label class="control-label form-control-label"><?=$filter->title?></label>
    </div>
    <div class="col-md-9">
        <div>
            <label style="margin-right: 15px;">
                <i class="icmn-plus3" data-toggle="modal" data-target="#add_param_<?=$filter->id;?>"></i>
            </label>
            <?php foreach($filter->values as $paramKey =>$value){?>
                <label style="margin-right: 15px;">
                    <input
                        type="checkbox"
                        name="Products[parameters][]"
                        class="checks"
                        <?=(
                            $formModel->checkProductParameterFromRequest(Yii::$app->request->post('parameters'),$value->id) ||
                            $formModel->checkProductParameter($value->id)
                        )?"checked='checked'":''?>
                        value="<?=$value->id?>"
                    > <?=$value->title?>
                </label>
            <?php }?>
        </div>

        <?=$this->render('filter_modal',['filter'=>$filter])?>

    </div>
</div>
<?php
$this->registerJs('
        $("#add_param_'.$filter->id.' .addButton").click(function(){
            var data={
                "parameters":[],
                "title":$("#add_param_'.$filter->id.' input[name=\\"ParametrsValue[title]\\"]").val(),
                "title_ua":$("#add_param_'.$filter->id.' input[name=\\"ParametrsValue[title_ua]\\"]").val(),
                "title_en":$("#add_param_'.$filter->id.' input[name=\\"ParametrsValue[title_en]\\"]").val(),
                "parametr_id":$("#add_param_'.$filter->id.' input[name=\\"ParametrsValue[parametr_id]\\"]").val()
            };
             $("#filter-'.$filter->id.' .checks").each(function(){
                if($(this).prop("checked")) data["parameters"].push($(this).val());
             });
            console.log(data);
            $.post("'.\yii\helpers\Url::to(['/filter/default/add-value']).'",data,function(){
                $("#add_param_'.$filter->id.'").modal("hide");
                $.pjax.reload({
                    "container":"#filter-'.$filter->id.'",
                    data: data,
                    history: false,
                    method: "post"
                });
            });
        });
    ', \yii\web\View::POS_END);

    \yii\widgets\Pjax::end();
?>

