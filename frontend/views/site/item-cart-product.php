<?php
$bundle = \frontend\assets\AppAsset::register($this);
use \frontend\widgets\SvgWidget\SvgWidget;
use yii\helpers\Url;

if(!Yii::$app->session->isActive){Yii::$app->session->open();}
$cart = Yii::$app->session->get('cart');
?>
<td data-th="Product" class="wid_1">
    <div class="row">
        <div class="col-sm-3 hidden-xs">
            <a href="<?=$model->getUrl()?>">
                <img src="<?php echo $model->image->getUrl('70x70');?>" alt="" />
            </a>
        </div>
        <div class="col-sm-9">
            <p>
                <a href="<?=$model->getUrl()?>" style="color: inherit;">
                    <?php echo $model->getMultiLang('title');?>
                </a>
            </p>
        </div>
    </div>
</td>
<td class="wid_2"><?=$model->artikul?></td>
<td data-th="Quantity" class="wid_3 text-center">
    <input type="number"  class="form-control text-center count" value="<?php echo $cart[$model->id]['qty'];?>" data-price="<?=$model->price?>"   min="1">
</td>
<td data-th="Price" class="wid_4 text-leftr pricer"><span class="price"><?=$model->price?></span> грн</td>
<td data-th="Subtotal" class="wid_5 text-left pricer"><span class="cost"><?=$model->price?></span> грн</td>
<td class="wid_6 actions" data-th="">
    <button class="btn btn-danger btn-sm delete_item" ><i class="fa fa-trash-o"></i></button>
</td>

