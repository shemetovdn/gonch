
        $(document).ready(function(){

            $("button.buyb").click(function(){
                var id = $(this).attr("data-id");
                var price = $(this).attr("data-price");
                var category_href = $(this).attr("data-category-href");
                var availability = $(this).attr("data-availability");
                if(availability == 1){
                    $.ajax({
                        url:"/site/add-to-cart",
                        type:"POST",
                        data: "id="+id+"&price="+price,
                        success:function(data){
                            if(data == 0){
                                $("#addToCart_popup .dialog__content > p.success").addClass("hide");
                                $("#addToCart_popup .dialog__content > p.error").removeClass("hide");
                            }else{
                                $("#addToCart_popup .dialog__content > p.error").addClass("hide");
                                $("#addToCart_popup .dialog__content > p.success").removeClass("hide");
                                $(".cart_count").text(data);
                                $("a[href = '/cart']").addClass("hover");
                            }
                            var dlg = new DialogFx( document.getElementById("addToCart_popup") );
                            dlg.toggle();
                            setTimeout(function () {
                                dlg.toggle();
                            }, 2000)
                        }
                    })
                }else{
                    $("#availability_modal").find(".category_href").attr('href', category_href);
                    var dlg = new DialogFx( document.getElementById("availability_modal") );
                    dlg.toggle();

                }

            });

            $(document).on("click",".heart, .likeprod", function(){
                var user_id = $(this).attr("data-user-id");
                var product_id = $(this).attr("data-product-id");

                if(!user_id){
                    $.ajax({
                        url:"/site/wishlist-before-login",
                        type:"POST",
                        data: "product_id="+product_id,
                        success:function(data){

                        }
                    })

                    var somedialog = document.getElementById("somedialog");
                    var dlg = new DialogFx( somedialog );
                    dlg.toggle();
                }else{
                    $.ajax({
                        url:"/site/add-to-wishlist",
                        type:"POST",
                        data: "product_id="+product_id+"&user_id="+user_id,
                        success:function(data){
                            if(data == 0){
                                $("#wishlist_add .dialog__content > p.success").addClass("hide");
                                $("#wishlist_add .dialog__content > p.error").removeClass("hide");
                            }else if(data ==1){
                                $("#wishlist_add .dialog__content > p.error").addClass("hide");
                                $("#wishlist_add .dialog__content > p.success").removeClass("hide");
                            }
                            var dlg = new DialogFx( document.getElementById("wishlist_add") );
                            dlg.toggle();
                            setTimeout(function () {
                                dlg.toggle();
                            }, 2000)
                        }
                    })
                }
            });

            $(".signup").click(function(){
                var dlg = new DialogFx( document.getElementById("somedialog") );
                dlg.toggle();
                console.log(dlg.toggle());


            });

            $(".proile").click(function(event){
                event.preventDefault();
                var href = $(this).attr("href");
                var somedialog = document.getElementById("somedialog");
                var dlg = new DialogFx( somedialog );
                dlg.toggle();
            });
            $(".wishes").click(function(event){
                event.preventDefault();
                var href = $(this).attr("href");
                $.ajax({
                    url:"/site/toggle-return",
                    type:"POST",
                    data: "return="+1,
                    success:function(data){}
                })
                var somedialog = document.getElementById("somedialog");
                var dlg = new DialogFx( somedialog,{
                    onCloseDialog: function(event){
                        $.ajax({
                            url:"/site/toggle-return",
                            type:"POST",
                            data: "return="+0,
                            success:function(data){}
                        })
                    }
                } );
                dlg.toggle();
            });

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                var target = $(e.target).attr("href");
                if(target == "#menu2"){
                    var owl_assoc = $('#owl_assoc');
                    owl_assoc.on('initialized.owl.carousel', createProductListing);
                    owl_assoc.owlCarousel({
                        margin: 0,
                        nav: false,
                        loop: true,
                        navText: ['', ''],
                        responsiveClass:true,
                        responsive:{
                            0:{
                                items:1,
                                nav:true
                            },
                            600:{
                                items:2,
                                nav:false
                            },
                            1000:{
                                items:3,
                                nav:true,
                                loop:false
                            }
                        }
                    });
                }

            });
           $(document).on("click", ".remove_from_wishlist",function () {
               var id = $(this).attr("data-product-id");
               var url_to = "/profile/wishes";
               $.pjax.reload({url: url_to,"container":"#wishesPjax", history:true,type: "POST", data: "id="+id, timeout: 10000}).done(function() {
               })
           });


            $(document).on("click", ".toggle_text",function (event) {
                event.preventDefault();
                if($(this).parents(".row").find(".newstext").hasClass("open")){
                    $(this).removeClass("open");
                    $(this).parents(".row").find(".newstext").removeClass("open");
                    $(this).parents(".row").find(".newstext").animate({
                        height: "75px"
                    }, 1000);
                }else{
                    $(this).addClass("open");
                    $(this).parents(".row").find(".newstext").addClass("open");
                    $(this).parents(".row").find(".newstext").animate({
                        height: $(this).parents(".row").find(".newstext").attr("data-height")+"px"
                    }, 1000);
                }
            });

            $(".newstext").attr("data-height", $(".newstext").height())
            $(".newstext").height(75);

            $("#orders-shipping_method").change(function(){
                var shipping_id = $(this).val();
                // var shiping_array = document.querySelectorAll();
                if(shipping_id == 1){
                    $("div[data-shipping='1']").show();
                    $("div[data-shipping='0']").hide();
                    $("input#orders-city").prop("disabled", false);
                }else{
                    $("div[data-shipping='1']").hide();
                    $("div[data-shipping='0']").show();
                    $("input#orders-city").prop("disabled", true);
                }
            });

            $("#orders-city").change(function(){
                var city_id = $(this).val();
                var first_item = $("#delivery_office option:first-child").text();

                $.ajax({
                    url:"/checkout/get-office",
                    type:"POST",
                    data: "city_id="+city_id,
                    success:function(data){
                        data = JSON.parse(data);
                        var html = "<option value>"+first_item+"</option>>";

                    for(var i = 0; i< data.length; i++){
                        html += "<option value='"+data[i].id+"'>"+data[i].title+"</option>";
                    }
                        $("#delivery_office").html(html);
                    }
                })

            });

            if(window.innerWidth < 768){
                $(document).click(function(event){
                    if($(event.target).parents("#site-search").length == 0 && !$(event.target).hasClass('searh')){
                        $('#site-search').hide('normal');

                    }
                })
            }

        });
