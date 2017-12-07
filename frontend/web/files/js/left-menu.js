(function(){

    // Добавляем выбранной категории класс "active"
    $(document).ready(function(){
        var activeElements = $('.nav.navbar-nav .dropdown').find('li.active');
        activeElements.each(function(i, el){
            $(el).parents('.nav.navbar-nav li').addClass('active');
        });
    });
    // Добавляем выбранной категории класс "active" END

    $(document).ready(function(){
        setTimeout(buildMenu, 300);
        // buildMenu();
    });
    $(window).on("orientationchange, resize", function() {
        buildMenu();
    });

    function buildMenu() {
        if(screen.width >= 768){
            $('.site-maska').height(document.body.offsetHeight);

            var navbarHeight = $('#navbar').height();
            $('#navbar .dropdown-menu').css('minHeight', navbarHeight + 'px');

            $('#navbar li').hover(function(){
                var space=$(this).find(">ul .space");
                if(!space.length){
                    space = $("<span class='space'></span>").height($(this).position().top);
                    $(this).find(">ul").prepend(space);
                }
                if(!$(this).find("ul").length) {
                    $(this).find("a").removeAttr("data-toggle");
                    $(this).find("a").removeAttr("role");
                    $(this).find("a").removeAttr("data-target");
                    $(this).find("a").removeAttr("aria-haspopup");
                    $(this).find("a").removeAttr("aria-expanded");
                    $(this).find("a .carett").remove();
                }
                if(!$(this).find("ul ul").length) $(this).find("ul").addClass('blue');

            });

            $('#navbar .nav.navbar-nav').hover(function(){
                $('.site-maska').fadeIn();
            }, function() {
                $('.site-maska').fadeOut();
            });
        }

        if(screen.width < 768){
            $('#navbar>ul>li>ul').each(function(){
                $(this).find("a").removeAttr("data-toggle");
                $(this).find("a").removeAttr("role");
                $(this).find("a").removeAttr("data-target");
                $(this).find("a").removeAttr("aria-haspopup");
                $(this).find("a").removeAttr("aria-expanded");
                $(this).find("a .carett").remove();
                $(this).find("ul").addClass("in");
            });
        }
    }

})();



// console.dir(document.body.offsetHeight)