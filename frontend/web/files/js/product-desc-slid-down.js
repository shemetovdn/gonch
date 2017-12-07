$(document).ready(function(){

    // $('.sortpr').click(function(){
    //     setTimeout(function(){
    //         products.forEach(function(el){
    //             new descList(el);
    //         });
    //     }, 500);
    // });

});

$(document).click(function (event) {
    if(
        $(event.target).parents('.popupproduct').length == 0 &&
        !$(event.target).hasClass('plus') &&
        $(event.target).parents('.plus').length == 0 &&
        !$('.someproduct').hasClass('line-bloke')
    ){
        $(".popupproduct.desc-list").slideUp();
    }
});

function ShowProduct(){
    var view = $(".sortpr.active").attr("data-show");
    if(view == "list"){
        $("#catalogPjax .someproduct").addClass("line-bloke");
    }
    if(view == "grid"){
        $("#catalogPjax .someproduct").removeClass("line-bloke");
    }
}

$(".sortpr").click(function(){
    if($(this).data('show')=='grid') $('.desc-list').hide();
    if($(this).data('show')=='list') $('.desc-list').show();
    $(".sortpr").removeClass("active");
    $(this).addClass("active");
    ShowProduct();
});

$(document).ready(function(){
    generateDescList();
});

$(window).on("orientationchange, resize", function() {
    generateDescList();
});

$('.sortpr').on("click", function() {
    generateDescList();
});

function generateDescList() {
    var products = document.querySelectorAll('.product-lister-outer .whith-desc-list');
    products.forEach(function(el){
        new descList(el);
    });
}

function descList(element){
    var parent = $(element).closest('.product-lister-outer');
    var parentWidth = parent.outerWidth();
    var dropElement = element.querySelector('.desc-list');
    var scrollHeight = element.clientHeight-120;
    var rowHeight = element.clientHeight-58;
    $(element).find('.row').eq(0).css({'height': rowHeight+'px'});
    $(element).find('.scroll-container').css({'height': scrollHeight+'px'});
    element.querySelectorAll('.plus').forEach(function(triger){
        triger.addEventListener('click', function(){
            if($(dropElement).is(':hidden')){
                var allDropdouns = document.querySelectorAll('.product-lister-outer .whith-desc-list .desc-list');
                $(allDropdouns).hide();
                if(screen.width >= 768){
                    $(dropElement).slideDown("slow");
                }
            }
        });
    });
    element.querySelectorAll('.minus').forEach(function(triger){
        triger.addEventListener('click', function(){
            $(dropElement).slideUp();
        });
    });
    var left = element.getBoundingClientRect().left - parent.offset().left;
    if (left == NaN) left = 0;
    var dropList = element.querySelector('.desc-list');
    dropList.style.width = parentWidth + 'px';
    dropList.style.left = -left + 'px';
    $(dropList).css('left', -left + 'px');
}


function showHideList(){
    var id = this.dataset.listTrigerId;
    var parent = $(this).closest('.owl-dropdown-block');
    var dropdownContent = parent.find('[data-list-content="' + id + '"]');
    if(dropdownContent.is(':hidden')){
        var allDropdouns = document.querySelectorAll('.owl-carusel-product-list-dropdown-block .desc-list');
        $(allDropdouns).hide();
        dropdownContent.slideDown("slow");
    }
}

function createProductListing(event){
    var scrollHeight = event.currentTarget.clientHeight-60-63-45;
    var parentElement = event.currentTarget;
    var notThis = true;
    while (notThis){
        if (parentElement.classList != undefined && !parentElement.classList.contains('owl-dropdown-block')){
            parentElement = parentElement.parentNode;
        }else {
            notThis = false;
        }
    }
    var insertTo = parentElement.querySelector('.owl-carusel-product-list-dropdown-block .inner');
    insertTo.innerHTML = '';
    var allElements = parentElement.querySelectorAll('[data-list-triger]');
    allElements.forEach(function(el){
        $(el.querySelector('.desc-list')).find('.scroll-container').css({'height': scrollHeight+'px'});
        var clonedElement = el.querySelector('.desc-list').cloneNode(true);
        el.querySelector('.desc-list').remove();
        insertTo.appendChild(clonedElement);
        var trigerMinus = clonedElement.querySelector('.minus');
        trigerMinus.addEventListener('click', function(){
            $(clonedElement).slideUp();
        });
        var trigerButton = el.querySelector('.plus');
        trigerButton.removeEventListener('click', showHideList);
        trigerButton.addEventListener('click', showHideList);
    });
}


// hide products after second on tablet devices
// $(document).ready(function(){
//     showFirs();
// });
// $(window).on("orientationchange, resize", function() {
//     showFirs();
// });
// function showFirs() {
//     $('*[data-show-first="2"] *[data-hide="true"]').show();
//     if($(window).width()>767 && $(window).width()<992){
//         $('*[data-show-first="2"]').each(function(i, el){
//             $(el).find('*[data-hide="true"]:gt(1)').hide();
//         });
//     }
// }
// hide products after second on tablet devices END
