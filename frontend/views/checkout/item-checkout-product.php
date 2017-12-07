<?php
$bundle = \frontend\assets\AppAsset::register($this);
use \frontend\widgets\SvgWidget\SvgWidget;
if(!Yii::$app->session->isActive){Yii::$app->session->open();}
$cart = Yii::$app->session->get('cart');
?>
<td data-th="Product" class="wid_1 column column-1">
    <div class="row">
        <div class="col-sm-4 hidden-xs"><img src="<?php echo $model->image->getUrl('70x70');?>" alt="" /></div>
        <div class="col-sm-8">
            <p><?php echo $model->getMultiLang('title');?></p>
        </div>
    </div>
</td>
<td data-th="Quantity" class="wid_3 text-center column column-2">
    <input type="number"  class="form-control text-center count" value="<?php echo $cart[$model->id]['qty'];?>" data-price="<?=$model->price?>" min="1">
</td>
<td data-th="Subtotal" class="wid_5 text-left pricer column column-3"><span class="cost"><?=$model->price*$cart[$model->id]['qty'];?></span> грн</td>
<td class="wid_6 actions column column-4" data-th="">
    <button class="btn btn-danger btn-sm delete_item" ><i class="fa fa-trash-o"></i></button>
</td>

