<?
$bundle = \frontend\assets\AppAsset::register($this);

$this->registerJs('

    function setTotalPrice(){

        var costs = document.querySelectorAll("span.cost");
        var totalCost = 0;
        for(var i =0; i <costs.length; i++){
        var parent = $(costs[i]).parents("div.product_info");   
        var count = $(parent).find(".count").val(); 
        var price = $(parent).find(".count").attr("data-price");
        var cost = count*price;

        $(parent).find("div.price > span.cost").text(cost);
        }
        var products = document.querySelectorAll("div.body-out");
        
                $.ajax({
        url: "get-cart-total",
        type:"POST",
        data: "id="+1,
        success: function(data){
$("#totalCost").text(data);
        }
        
        });
        
    }
    
    $(document).on("input", "input.count", function () {
    var self = $(this);
        var count = $(this).val(); 
        var id = $(this).parents("div.body-out").attr("data-key");
        var price = $(this).attr("data-price");
        var cost = count*price;
        var product = $(this).parents("div.body-out").find(".product_info span.cost");
        
        for(var i =0; i < product.length; i++){
               $(product[i]).text(cost);
        }
        
        $.ajax({
        url: "change-amount",
        type:"POST",
        data: "product_id="+id+"&qty="+count,
        success: function(data){
            setTotalPrice();
        }
        
        });

});

 $(".delete_item").click(function(){
    var id = $(this).parents("div.body-out").attr("data-key");
    var url_to = "'.\yii\helpers\Url::to().'";
    $.pjax.reload({url: url_to,"container":"#cartPjax", history:true,type: "POST", data: "id="+id, timeout: 10000}).done(function() {
 setTotalPrice();
    })

 });
 
 $(window).resize(function(){
    var url_to = "'.\yii\helpers\Url::to().'";
    $.pjax.reload({url: url_to,"container":"#cartPjax", history:true,type: "POST", timeout: 10000}).done(function() {
 setTotalPrice();
 })
  })
    setTotalPrice();
', yii\web\View::POS_READY);
echo \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => 'item-cart-product-dev',
    'options' => [
        'tag' => false,
    ],
    'itemOptions' => [
        'tag' => 'div',
        'class'=>'body-out',
    ],
    'summary' => '<input type="hidden" id="summary" value="{totalCount}">',
    'summaryOptions' => [
        'tag' => 'span',
        'class' => 'my-summary'
    ],
]);
?>