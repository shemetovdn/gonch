<?
$bundle = \frontend\assets\AppAsset::register($this);

//$this->registerJs('
//
//    function setTotalPrice(){
//
//        var costs = document.querySelectorAll("span.cost");
//        var totalCost = 0;
//        for(var i =0; i <costs.length; i++){
//
//        totalCost = totalCost + +$(costs[i]).text();
//
//        }
//        $("#totalCost").text(totalCost);
//    }
//
//    $(document).on("input", "input.count", function () {
//        var count = $(this).val();
//        var id = $(this).parents("tr").attr("data-key");
//        var price = $(this).attr("data-price");
//        var cost = count*price;
//        $(this).parents("tr").find("td > span.cost").text(cost);
//        setTotalPrice();
//        $.ajax({
//        url: "change-amount",
//        type:"POST",
//        data: "product_id="+id+"&qty="+count+"&price ="+price,
//        success: function(data){
//            console.log(data);
//        }
//
//        });
//
//    });
//
// $(".delete_item").click(function(event){
//  event.preventDefault();
//    var id = $(this).parents("tr").attr("data-key");
//    var url_to = "'.\yii\helpers\Url::to().'";
//    $.pjax.reload({url: url_to,"container":"#checkoutPjax", history:true,type: "POST", data: "id="+id, timeout: 10000}).done(function() {
// setTotalPrice();
//    })
//
// });
//
//    setTotalPrice();
//', yii\web\View::POS_READY);



echo \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => 'item-checkout-product-dev',
    'options' => [
//        'tag' => 'tbody',
//        'class' => 'checkout-table',
//        'id' => '',
    ],
    'layout' => "{items}
{summary}
",
    'itemOptions' => [
//        'tag' => 'tr',
//        'class' => '',
    ],
    'summary' => '<input type="hidden" id="summary" value="{totalCount}">',
    'summaryOptions' => [
        'tag' => 'span',
        'class' => 'my-summary'
    ],
]);
?>