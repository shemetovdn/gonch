<?

$this->title='Invoice #'.$model->idVal;

    $this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>

<div class="separator bottom"></div>


    <h3 class="glyphicons credit_card"><i></i>Invoice</h3>
    <div class="innerLR innerB shop-client-products cart invoice">

        <table class="table table-invoice">
            <tbody>
            <tr>
                <td style="width: 58%;">
                    <div class="media">
                        <div class="media-body hidden-print">
                            <div class="alert alert-primary">
                                <strong>Note:</strong><br>
                                This page is optimized for print. Try print the invoice and check out the preview.
                                For example, this note will not be visible.
                            </div>
                            <div class="separator bottom"></div>
                        </div>
                    </div>
                </td>
                <td class="right">
                    <div class="innerL">
                        <h4>#<?=$model->idVal?> / <?=Yii::$app->formatter->asDate($model->created_at,'php:d M Y')?></h4>
                        <button type="button" data-toggle="print" class="btn btn-default btn-icon glyphicons print hidden-print"><i></i> Print invoice</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="separator bottom"></div>
        <div class="well">
            <table class="table table-invoice">
                <tbody>
                <tr>
                    <td style="width: 50%;">
                        <p class="lead">Company information</p>
                        <h2><?=$model->store->title?></h2>
                        <address class="margin-none">
                            <?=$model->store->address->get('<strong>%a %A %c,</strong><br>%r %C %z')?><br>
                            <abbr>e-mail:</abbr> <a><?=$model->store->email?></a><br>
                            <abbr>phone:</abbr> <?=$model->store->phone?><br>
                            <abbr>fax:</abbr> <?=$model->store->fax?>
                        </address>
                    </td>
                    <td class="right">
                        <p class="lead">Client information</p>
                        <h2><?=$model->client->first_name?> <?=$model->client->last_name?></h2>
                        <address class="margin-none">
                            <?=$model->billingAddress->get('<strong>%a %A %c,</strong><br>%r %C %z')?><br>
                            <abbr>e-mail:</abbr> <a><?=$model->client->email?></a><br>
                            <abbr>phone:</abbr> <?=$model->client->phone?><br>
                            <div class="separator line"></div>
                            <p class="margin-none"><strong>Shipping Address:</strong><br><?=$model->shippingAddress->get('%a %A %c,<br>%r %C %z')?></p>
                            <div class="separator line"></div>
                            <?
                                if($model->comment){

                            ?>
                                    <p class="margin-none"><strong>Note:</strong><br><?=$model->comment?></p>
                            <?
                                }
                            ?>
                        </address>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <table class="table table-bordered table-primary table-striped table-vertical-center">
            <thead>
            <tr>
                <th style="width: 1%;" class="center">No.</th>
                <th></th>
                <th style="width: 50px;">Qty</th>
                <th style="width: 80px;">Price</th>
                <th style="width: 80px;">Subtotal</th>
            </tr>
            </thead>
            <tbody>

            <?
                foreach($model->products as $num=>$product) {

            ?>

                    <!-- Cart item -->
                    <tr>
                        <td class="center"><?=$num+1?></td>
                        <td>
                            <h5><?=$product->dbProduct->title?> (UPC: <?=$product->dbProduct->upc_code?>)</h5>
                            <? foreach($product->dbProduct->paramSelectors as $id=>$par){ ?>
                                <span class="col" style="width: 80px; float: left;">
									<?=$par['title']?>:<br>
									<span class="label label-default" style="min-width: 50px;display: inline-block; text-align: center;">
                                        <?=ucfirst($product->dbProduct->allParameters[$id]->value)?>
                                    </span>
								</span>
                            <? } ?>

                        </td>
                        <td class="center"><?=$product->qty?></td>
                        <td class="center"><?=Yii::$app->formatter->asCurrency($product->price)?></td>
                        <td class="center"><?=Yii::$app->formatter->asCurrency($product->totalPrice)?></td>
                    </tr>
                    <!-- // Cart item END -->
            <?
                }
            ?>


            </tbody>
        </table>
        <div class="separator bottom"></div>

        <!-- Row -->
        <div class="row">

            <!-- Column -->
            <div class="col-md-8">
                <?
                    if($model->comment){
                ?>
                        <div class="box-generic">
                            <p class="margin-none"><strong>Note:</strong><br><?=$model->comment?></p>
                        </div>
                <?
                    }
                ?>
            </div>
            <!-- Column END -->

            <!-- Column -->
            <div class="col-md-4">
                <table class="table table-borderless table-condensed cart_total">
                    <tbody>
                    <tr>
                        <td class="right">Subtotal:</td>
                        <td class="right strong"><?=Yii::$app->formatter->asCurrency($model->subtotal)?></td>
                    </tr>
<!--                    <tr>-->
<!--                        <td class="right">Delivery:</td>-->
<!--                        <td class="right strong">$5.00</td>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td class="right">VAT:</td>-->
<!--                        <td class="right strong">$119.00</td>-->
<!--                    </tr>-->
                    <tr>
                        <td class="right">Total:</td>
                        <td class="right strong"><?=Yii::$app->formatter->asCurrency($model->amount)?></td>
                    </tr>
<!--                    <tr class="hidden-print">-->
<!--                        <td colspan="2"><button type="submit" class="btn btn-block btn-primary btn-icon glyphicons right_arrow"><i></i>Proceed to Payment</button></td>-->
<!--                    </tr>-->
                    </tbody>
                </table>
            </div>
            <!-- // Column END -->

        </div>
        <!-- // Row END -->

    </div>
