

        if(window.devicePixelRatio > 1){
            var multiplier = window.devicePixelRatio;
            var images = document.querySelectorAll('img.optimizer');
            images.forEach(function(el){
                var sizeX = el.width;
                var sizeY = el.height;
                var imageType = el.src.substr(-4);
                var imageName = el.src.substr(0, el.src.length - 4);
                imageName += "_x" + multiplier + imageType;
                // imageName += "@" + multiplier + 'x' + imageType;
                var newImg = new Image();
                newImg.src = imageName;
                newImg.onload = function() {
                    el.src = imageName;
                    el.width = sizeX;
                    el.height = sizeY;
                }
            });
        };
        
        $(document).ready(function(){
            $("table").clone().appendTo('.somnewtable');
        });

        // $(document).ready(function(){
        //     $(".plus").click(function(){
        //         $("#hidden").slideToggle("slow");
        //         return false;
        //     });
        // });


        $(document).ready(function(){
            var owl_1 = $('#index-1');
            owl_1.on('initialized.owl.carousel', createProductListing);
            owl_1.owlCarousel({
                margin: 0,
                nav: false,
                loop: false,
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
            })
        });

        $(document).ready(function(){
            var owl_2 = $('#index-2');
            owl_2.on('initialized.owl.carousel', createProductListing);
            owl_2.owlCarousel({
                margin: 0,
                nav: false,
                loop: false,
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
            })
        });

        $(document).ready(function(){
            var owl_3 = $('#index-3');
            owl_3.on('initialized.owl.carousel', createProductListing);
            owl_3.owlCarousel({
                margin: 0,
                nav: false,
                loop: false,
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
            })
        });

        $(document).ready(function(){
            var owl = $('.customcarusel-1 .owl-carousel');
            owl.owlCarousel({
                margin: 0,
                nav: false,
                loop: false,
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
            })
        });


        $(document).ready(function(){
            $('body').on("click", ".positionclose, .searh", function () {
                $('#site-search').toggle('normal');
                return false;
            });
        });

        var App = (function () {

            //=== Use Strict ===//
            'use strict';

            //=== Private Variables ===//
            var gallery = $('#js-gallery');

            //=== Gallery Object ===//
            var Gallery = {
                zoom: function(imgContainer, img) {
                    var containerHeight = imgContainer.outerHeight(),
                        src = img.attr('src');

                    if ( src.indexOf('/products/normal/') != -1 ) {
                        // Set height of container
                        imgContainer.css( "height", containerHeight );

                        // Switch hero image src with large version
                        img.attr('src', src.replace('/products/normal/', '/products/zoom/') );

                        // Add zoomed class to gallery container
                        gallery.addClass('is-zoomed');

                        // Enable image to be draggable
                        img.draggable({
                            drag: function( event, ui ) {
                                ui.position.left = Math.min( 100, ui.position.left );
                                ui.position.top = Math.min( 100, ui.position.top );
                            }
                        });
                    } else {
                        // Ensure height of container fits image
                        imgContainer.css( "height", "auto" );

                        // Switch hero image src with normal version
                        img.attr('src', src.replace('/products/zoom/', '/products/normal/') );

                        // Remove zoomed class to gallery container
                        gallery.removeClass('is-zoomed');
                    }
                },
                switch: function(trigger, imgContainer) {
                    var src = trigger.attr('href'),
                        thumbs = trigger.siblings(),
                        img = trigger.parent().prev().children();

                    // Add active class to thumb
                    trigger.addClass('is-active');

                    // Remove active class from thumbs
                    thumbs.each(function() {
                        if( $(this).hasClass('is-active') ) {
                            $(this).removeClass('is-active');
                        }
                    });

                    // Reset container if in zoom state
                    if ( gallery.hasClass('is-zoomed') ) {
                        gallery.removeClass('is-zoomed');
                        imgContainer.css( "height", "auto" );
                    }

                    // Switch image source
                    img.attr('src', src);
                }
            };

            //=== Public Methods ===//
            function init() {

                // Listen for clicks on anchors within gallery
                gallery.delegate('a', 'click', function(event) {
                    var trigger = $(this);
                    var triggerData = trigger.data("gallery");

                    if ( triggerData === 'zoom') {
                        var imgContainer = trigger.parent(),
                            img = trigger.siblings();
                        Gallery.zoom(imgContainer, img);
                    } else if ( triggerData === 'thumb') {
                        var imgContainer = trigger.parent().siblings();
                        Gallery.switch(trigger, imgContainer);
                    } else {
                        return;
                    }

                    event.preventDefault();
                });

            }

            //=== Make Methods Public ===//
            return {
                init: init
            };

        })();

        App.init();
