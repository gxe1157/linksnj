/*
 Theme Name: Houzez
 Description: Houzez
 Author: Houzez
 Author: Houzez
 Version: 1.0
 */

var nice = false;
(function($){


    /* ------------------------------------------------------------------------ */
    /*	BODY LOAD
    /* ------------------------------------------------------------------------ */
    window.setTimeout(function(){
        jQuery('body').addClass('loaded');
    }, 10);

    /* ------------------------------------------------------------------------ */
    /*	NICE SCROLL
    /* ------------------------------------------------------------------------ */
    //nice = $("html").niceScroll();
    var nice = $("html").niceScroll({
         //cursorcolor: "#666",
         scrollspeed: 100,
         mousescrollstep: 30,
         //boxzoom: false,
         //autohidemode: false,
         cursorborder: "0 solid #666",
         //cursorborderradius: "0",
         cursorwidth: 6,
         //background: "#666",
         //horizrailenabled: false
     });

    /* ------------------------------------------------------------------------ */
    /*	RANGE SLIDER
    /* ------------------------------------------------------------------------ */
    if($( "#slider-price").length >0) {
        $("#slider-price").slider({
            range: true,
            min: 500,
            max: 5000,
            values: [500, 5000],
            slide: function (event, ui) {
                $("#min-price").val("$ " + ui.values[0]);
                $("#max-price").val("$ " + ui.values[1]);
            }
        });
        $("#min-price").val("$ " + $("#slider-price").slider("values", 0));
        $("#max-price").val("$ " + $("#slider-price").slider("values", 1));
    }

    if($( "#slider-size").length >0) {
        $("#slider-size").slider({
            range: true,
            min: 0,
            max: 6000,
            values: [500, 6000],
            slide: function (event, ui) {
                $("#min-size").val(ui.values[0] + " sqft");
                $("#max-size").val(ui.values[1] + " sqft");
            }
        });
        $("#min-size").val($("#slider-size").slider("values", 0) + " sqft");
        $("#max-size").val($("#slider-size").slider("values", 1) + " sqft");
    }

    /* ------------------------------------------------------------------------ */
    /*	ACCORDIAN
    /* ------------------------------------------------------------------------ */

    $('.accord-tab > .expand-icon').click(function() {
        if($(this).hasClass('active')!=true)
        {
            $('.accord-tab > .expand-icon').removeClass('active');
            $(this).addClass('active');

            $('.accord-tab > .expand-icon').parent().next('.accord-content').slideUp();
            $(this).parent().next('.accord-content').slideDown();

        }
    });

    /* ------------------------------------------------------------------------ */
    /*	ACCORDIAN ADD PROPERTY
    /* ------------------------------------------------------------------------ */

    $('.add-title-tab > .add-expand').addClass('active');
    $('.add-title-tab > .add-expand').click(function() {
        var thisTab = $(this);
        var activeClass = 'active';
        var tabContent = '.add-tab-content';

        if(thisTab.hasClass(activeClass)){
            thisTab.parent().next(tabContent).slideUp();
            thisTab.removeClass(activeClass);
        }else{
            thisTab.parent().next(tabContent).slideDown();
            thisTab.addClass(activeClass);
        }
    });

    /* ------------------------------------------------------------------------ */
    /*	MAP VIEW TABBER
    /* ------------------------------------------------------------------------ */
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        e.target // newly activated tab
        e.relatedTarget // previous active tab
    });

    /* ------------------------------------------------------------------------ */
    /*	BOOTSTRAP SELECT PICKER
    /* ------------------------------------------------------------------------ */
    if($('.selectpicker').length > 0){
        $('.selectpicker').selectpicker();
    }

    /* ------------------------------------------------------------------------ */
    /*	POST CARDS MASONRY
    /* ------------------------------------------------------------------------ */
    $(window).on('load',function(){
        if($('.grid-block').length > 0){
            $('.grid-block').isotope({
                // options
                itemSelector: '.grid-item',
                //layoutMode: 'fitRows'
            });
        }
    });

    /* ------------------------------------------------------------------------ */
    /*	LOGIN TABBER
    /* ------------------------------------------------------------------------ */
    /*$('.login-tabs').each(function(){

    });*/
    /*$('.widget').children('.login-tabs li').on('click',function(){
        alert('ok');
        if($(this).hasClass('active')!=true){
            $('.login-tabs > li').removeClass('active');
            $(this).addClass('active');
            //alert('ok');
            $(this).parents().find('.tab-pane').removeClass('in active');
            $(this).parents().find('.tab-pane').eq($(this).index()).addClass('in active');
        }
    });*/
    function fave_tabber(target){
        $(""+target+""+' .login-tabs > li').on('click',function(){
            if($(this).hasClass('active')!=true){
                $('.login-tabs > li').removeClass('active');
                $(this).addClass('active');
                //alert('ok');
                $(""+target+""+' .login-block .tab-pane').removeClass('in active');
                $(""+target+""+' .login-block .tab-pane').eq($(this).index()).addClass('in active');
            }
        });
    }
    fave_tabber('.widget');
    fave_tabber('.footer-widget');
    fave_tabber('.modal');

    /* ------------------------------------------------------------------------ */
    /*	AGENT DETAIL TABBER
     /* ------------------------------------------------------------------------ */
    $('.detail-tabs > li').on('click',function(){

        if($(this).hasClass('active')!=true){
            $('.detail-tabs > li').removeClass('active');
            $(this).addClass('active');
            $('.detail-content-tabber .tab-pane').removeClass('active in');
            $('.detail-content-tabber .tab-pane').eq($(this).index()).addClass('active in');
        }
    });

    /* ------------------------------------------------------------------------ */
    /*	TOOLTIP
    /* ------------------------------------------------------------------------ */

    $('[data-toggle="tooltip"]').tooltip();

    /* ------------------------------------------------------------------------ */
    /*	SHARE TOOLTIP
    /* ------------------------------------------------------------------------ */
    $('.actions .share-btn').on('click',function(){

        if($(this).children('.share_tooltip').hasClass('in')){
            $(this).children('.share_tooltip').removeClass('in');
            $(this).removeClass('active');
        }else{
            $(this).addClass('active');
            $('.actions li').children('.share_tooltip').removeClass('in');
            $(this).children('.share_tooltip').addClass('in');
        }

    });
    $(document).mouseup(function (e)
    {
        var tip = $(".share-btn");

        if (!tip.is(e.target) // if the target of the click isn't the container...
            && tip.has(e.target).length === 0) // ... nor a descendant of the container
        {
            $('.share_tooltip').removeClass('in');
        }
    });

    /* ------------------------------------------------------------------------ */
    /*	PAY DROPDOWN
    /* ------------------------------------------------------------------------ */
    $('.my-actions .pay-btn').on('click', function (event) {
        //$('.my-actions .pay-btn').parent().removeClass("open");
        if($(this).parent().hasClass("open")!=true){
            $('.my-actions .pay-btn').parent().removeClass("open");
            $(this).parent().addClass("open");
        }else{
            $(this).parent().removeClass("open");
        }
    });
    $('body').on('click', function (e) {
        if (!$('.my-actions .pay-btn').is(e.target) && $('.my-actions .pay-btn').has(e.target).length === 0 && $('.open').has(e.target).length === 0) {
            $('.my-actions .pay-btn').parent().removeClass('open');
        }
    });

    /* ------------------------------------------------------------------------ */
    /*	ACCOUNT DROPDOWN
    /* ------------------------------------------------------------------------ */
    /*$('.account-action > li').on('mouseover',function(){
        $('.nav-trigger').removeClass('mobile-open');
        if($(this).hasClass('active')){
            $(this).removeClass('active');
        }else{
            $('.account-action > li').removeClass('active');
            $(this).addClass('active');
        }
    });*/
    $(".account-action > li").on({
        mouseenter: function () {
            $('.nav-trigger').removeClass('mobile-open');
            $(this).addClass('active');
        },
        mouseleave: function () {
            $(this).removeClass('active');
        }
    });
    /*$(document).mouseup(function (e)
    {
        var tip = $('.account-action li');

        if (!tip.is(e.target) // if the target of the click isn't the container...
            && tip.has(e.target).length === 0) // ... nor a descendant of the container
        {
            $('.account-action li').removeClass('active');
        }
    });*/

    /* ------------------------------------------------------------------------ */
    /*	MOBILE MENU
    /* ------------------------------------------------------------------------ */
    function mobileMenu(){
        var siteMenu = $('.navi').html();
        $('.menu-nav-dropdown').html(siteMenu);

        $('.menu-nav-dropdown ul li').each(function(){
            $(this).has('ul').addClass('has-child');
        });

        $('.menu-nav-dropdown ul .has-child').append('<span class="expand-me"></span>');

        $('.expand-me').on('click',function(){
            var parent = $(this).parent('li');
            if(parent.hasClass('active')==true){
                parent.removeClass('active');
                parent.children('ul').slideUp();
            }else{
                parent.addClass('active');
                parent.children('ul').slideDown();
            }

        });

        $('.nav-trigger').on('click',function(){
            if($(this).hasClass('mobile-open')){
                $(this).removeClass('mobile-open');
            }else{
                $(this).addClass('mobile-open');
            }
        });
    }
    mobileMenu();

    /* ------------------------------------------------------------------------ */
    /*	SET COLUMNS HEIGHT
     /* ------------------------------------------------------------------------ */
    if($('.footer-widget').length > 0){
        $('.footer-widget').matchHeight();
    };

    if($('.grid').length > 0) {
        $('.grid').each(function () {
            $(this).children().find('img').matchHeight({
                byRow: true,
                property: 'height',
                target: null,
                remove: false
            });
        });
    }
    //if($('.grid-view').length > 0) {
        $(window).load(function(){
            $('.item-body,.post-card-description').matchHeight();
        })
    //}

    /* ------------------------------------------------------------------------ */
    /*	NAVIGATION
     /* ------------------------------------------------------------------------ */
    $('.navi ul li').each(function(){
        $(this).has('ul').addClass('has-child')
    })
    $('.navi ul .has-child').hover(

        function(){
            //$('.navi ul .has-child').removeClass('active');
            $(this).addClass('active');
        },
        function(){
            $(this).removeClass('active');
        }
    );

    /* ------------------------------------------------------------------------ */
    /*	CHANGE GRID LIST
     /* ------------------------------------------------------------------------ */
    $('.view-btn').on("click",function(){
        $('.view-btn').removeClass('active');
        $(this).addClass('active');
        if($(this).hasClass('btn-list'))
        {
            $('.property-listing').removeClass('grid-view').addClass('list-view');
        }
        else if($(this).hasClass('btn-grid')){
            $('.property-listing').removeClass('list-view').addClass('grid-view');
        }
    });

    /* ------------------------------------------------------------------------ */
    /*	SECTION HEIGHT
    /* ------------------------------------------------------------------------ */

    function setSectionHeight() {
        var section = $('body');
        var windowHeight = getWindowHeight();
        var windowWidth = getWindowWidth();

        var innerHeaderH = $('.header-section').innerHeight();
        var outerHeaderH = $('#header-section').innerHeight();
        var splashFootH = $('.splash-footer').innerHeight();
		var searchH = (windowHeight-innerHeaderH)-splashFootH;


        //$('#splash-section').css( 'min-height', windowHeight );
		$('.search-table').css( 'height', searchH );

        if($('body > #header-section').index()==0){
            //alert($('body #header-section').index());
            $('.screen-fix').css( 'height', windowHeight-outerHeaderH );
        }else{

            $('.screen-fix').css( 'height', windowHeight );
        }
    }
    function setVideoHeight() {
        if(getWindowWidth()<992){
            $('.banner-video').height($('.banner-video #video_background').outerHeight()-5);
        }else{
            $('.banner-video').height(600);
        }
    }

    setSectionHeight();

    $(window).bind('load',function(){
        setVideoHeight();
    });

    $(window).on('resize', function () {
        setSectionHeight();
        setVideoHeight();
    });

    function getWindowWidth() {
        return Math.max( $(window).width(), window.innerWidth);
    }

    function getWindowHeight() {
        return Math.max( $(window).height(), window.innerHeight);
    }

    /* ------------------------------------------------------------------------ */
    /*	ADVANCE DROPDOWN
    /* ------------------------------------------------------------------------ */
    $('.advance-btn').on('click',function(){
        $(this).toggleClass('active');
        if($(this).hasClass('active')==true)
        {
            $(this).children('i').removeClass('fa-caret-right').addClass('fa-caret-down');
            $('.advance-fields').slideDown();
        }else
        {
            $(this).children('i').removeClass('fa-caret-down').addClass('fa-caret-right');
            $('.advance-fields').slideUp();
        }
    });

    $('.advance-trigger').on('click',function(){
        $(this).toggleClass('active');
        if($(this).hasClass('active')==true)
        {
            $(this).children('i').removeClass('fa-plus-square').addClass('fa-minus-square');
            $('.field-expand').slideDown();
        }else
        {
            $(this).children('i').removeClass('fa-minus-square').addClass('fa-plus-square');
            $('.field-expand').slideUp();
        }
    });

    /* ------------------------------------------------------------------------ */
    /*	BANNER SLIDER
     /* ------------------------------------------------------------------------ */
    if($("#banner-slider").length > 0){
        $('#banner-slider').slick({
            infinite: false,
            speed: 300,
            slidesToShow:1,
            slidesToScroll: 1,
            arrows: true,
            dots: false,
        });
    }

    /* ------------------------------------------------------------------------ */
    /*	SLICK CAROUSEL
    /* ------------------------------------------------------------------------ */
    if($("#properties-carousel-6").length > 0) {

        $('#properties-carousel-6').slick({
            infinite: false,
            slidesToShow: 6,
            slidesToScroll: 6,
            arrows: false,
            speed:300,
            dots: true,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });

        $('.btn-prev').click(function(){
            $(this).addClass('active').next('button').removeClass('active');
            $('#properties-carousel-6').slick('slickPrev');
        })

        $('.btn-next').click(function(){
            $(this).addClass('active').prev('button').removeClass('active');
            $('#properties-carousel-6').slick('slickNext');
        })
    }
    if($("#properties-carousel-4").length > 0) {

        $('#properties-carousel-4').slick({
            infinite: false,
            slidesToShow: 4,
            slidesToScroll: 4,
            arrows: false,
            speed:300,
            dots: true,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });

        $('.btn-prev').click(function(){
            $(this).addClass('active').next('button').removeClass('active');
            $('#properties-carousel-4').slick('slickPrev');
        })

        $('.btn-next').click(function(){
            $(this).addClass('active').prev('button').removeClass('active');
            $('#properties-carousel-4').slick('slickNext');
        })
    }
    if($("#properties-carousel-3").length > 0) {

        $('#properties-carousel-3').slick({
            infinite: false,
            slidesToShow: 3,
            slidesToScroll: 3,
            arrows: false,
            dots: true,
            responsive: [
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });

        $('.btn-prev').click(function(){
            $(this).addClass('active').next('button').removeClass('active');
            $('#properties-carousel-3').slick('slickPrev');
        })

        $('.btn-next').click(function(){
            $(this).addClass('active').prev('button').removeClass('active');
            $('#properties-carousel-3').slick('slickNext');
        })
    }

    if($("#properties-carousel-2").length > 0) {

        $('#properties-carousel-2').slick({
            infinite: false,
            slidesToShow: 2,
            slidesToScroll: 2,
            arrows: false,
            dots: true,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });

        $('.btn-prev').click(function(){
            $(this).addClass('active').next('button').removeClass('active');
            $('#properties-carousel-2').slick('slickPrev');
        })

        $('.btn-next').click(function(){
            $(this).addClass('active').prev('button').removeClass('active');
            $('#properties-carousel-2').slick('slickNext');
        })
    }
    if($("#properties-carousel-1").length > 0) {

        $('#properties-carousel-1').slick({
            infinite: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            dots: true,
        });

        $('.btn-prev').click(function(){
            $(this).addClass('active').next('button').removeClass('active');
            $('#properties-carousel-1').slick('slickPrev');
        })

        $('.btn-next').click(function(){
            $(this).addClass('active').prev('button').removeClass('active');
            $('#properties-carousel-1').slick('slickNext');
        })
    }
    if($("#properties-carousel-grid").length > 0) {

        $('#properties-carousel-grid').slick({
            infinite: false,
            slidesToShow: 3,
            slidesToScroll: 3,
            arrows: false,
            dots: true,
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });

        $('.btn-prev').click(function(){
            $(this).addClass('active').next('button').removeClass('active');
            $('#properties-carousel-grid').slick('slickPrev');
        })

        $('.btn-next').click(function(){
            $(this).addClass('active').prev('button').removeClass('active');
            $('#properties-carousel-grid').slick('slickNext');
        })
    }
    
    if($("#carousel-post-card").length > 0) {

        $('#carousel-post-card').slick({
            infinite: false,
            slidesToShow: 4,
            slidesToScroll: 4,
            arrows: false,
            dots: true,
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });

        $('.btn-prev').click(function(){
            $(this).addClass('active').next('button').removeClass('active');
            $('#carousel-post-card').slick('slickPrev');
        })

        $('.btn-next').click(function(){
            $(this).addClass('active').prev('button').removeClass('active');
            $('#carousel-post-card').slick('slickNext');
        })
    }
    if($("#carousel-post-card-block").length > 0) {

        $('#carousel-post-card-block').slick({
            infinite: false,
            slidesToShow: 4,
            slidesToScroll: 4,
            arrows: false,
            dots: true,
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });

        $('.btn-prev').click(function(){
            $(this).addClass('active').next('button').removeClass('active');
            $('#carousel-post-card-block').slick('slickPrev');
        })

        $('.btn-next').click(function(){
            $(this).addClass('active').prev('button').removeClass('active');
            $('#carousel-post-card-block').slick('slickNext');
        })
    }


    if($("#testimonial-carousel").length > 0) {
        $('#testimonial-carousel').slick({
            infinite: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            dots: true,
        });
    }
    if($("#agents-carousel").length > 0){
        $('#agents-carousel').slick({
            infinite: false,
            slidesToShow: 4,
            slidesToScroll: 4,
            arrows: false,
            dots: true,
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
        $('.btn-prev').click(function(){
            $(this).addClass('active').next('button').removeClass('active');
            $('#agents-carousel').slick('slickPrev');
        })

        $('.btn-next').click(function(){
            $(this).addClass('active').prev('button').removeClass('active');
            $('#agents-carousel').slick('slickNext');
        })
    }
    if($("#partner-carousel").length > 0) {

        $('#partner-carousel').slick({
            infinite: false,
            slidesToShow: 4,
            slidesToScroll: 4,
            arrows: false,
            dots: true,
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });

        $('.btn-prev').click(function(){
            $(this).addClass('active').next('button').removeClass('active');
            $('#partner-carousel').slick('slickPrev');
        })

        $('.btn-next').click(function(){
            $(this).addClass('active').prev('button').removeClass('active');
            $('#partner-carousel').slick('slickNext');
        })
    }

    $('.property-widget-slider').slick({
        dots: true,
        speed: 500
    });

    /* ------------------------------------------------------------------------ */
    /*	DATETIME PICKER
    /* ------------------------------------------------------------------------ */
    /*if($('.date').length > 0) {
        $('.date').datetimepicker({
            format: 'DD/MM/YYYY',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down",
            }
        });
    }*/

    /* ------------------------------------------------------------------------ */
    /*	DETAIL PAGE SLIDE SHOW
    /* ------------------------------------------------------------------------ */
    $('.slide').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        //fade: true,
        asNavFor: '.slideshow-nav'
    });
    $('.slideshow-nav').slick({
        slidesToShow: 8,
        slidesToScroll: 1,
        asNavFor: '.slide',
        arrows: false,
        dots: false,
        centerMode: true,
        centerPadding: '0px',
        focusOnSelect: true,
        infinite: true,
    });

    /* ------------------------------------------------------------------------ */
    /*	DETAIL LIGHT BOX SLIDE SHOW
    /* ------------------------------------------------------------------------ */
    if($("a[rel^='prettyPhoto']").length > 0) {
        $("a[rel^='prettyPhoto']").prettyPhoto({
            allow_resize: true, /* Resize the photos bigger than viewport. true/false */
            default_width: 900,
            default_height: 500,
            animation_speed: 'normal',
            theme: 'default',
            slideshow: 3000,
            autoplay_slideshow: false,
        });
    }

    /* ------------------------------------------------------------------------ */
    /*	DETAIL LIGHT BOX SLIDE SHOW
    /* ------------------------------------------------------------------------ */
    function lightBoxSlide() {
        $('.lightbox-slide').show(function(){
            $('.lightbox-slide').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                //fade: true,
            });
        });
    }

    /* ------------------------------------------------------------------------ */
    /*	LIGHT BOX
    /* ------------------------------------------------------------------------ */

    var popupRightWidth = $('.lightbox-right').innerWidth();

    function lightBox(){
        $('.popup-trigger').on('click',function(){
            $('#lightbox-popup-main').addClass('active').addClass('in');
        });
        $('.lightbox-close').on('click',function(){
            $('#lightbox-popup-main').removeClass('active').removeClass('in');
        });
    }
    lightBox();

    function popupResize(){
        var popupWidth = getPopupWidth()-60;
        $('.lightbox-popup').css('width',popupWidth);

        if($('.lightbox-right').length > 0){

            var popupRightWidth = $('.lightbox-right').innerWidth();

            $('.lightbox-left').css('width', (popupWidth - popupRightWidth));
            $('.gallery-inner').css('width', (popupWidth - popupRightWidth)-40);
            $('.lightbox-right').addClass('in');
            $('.lightbox-left .lightbox-close').removeClass('show');
            //$('.lightbox-left .expand-icon').hide('show');

            if (Modernizr.mq('(max-width: 1199px)')) {
                $('.expand-icon').removeClass('compress');
                $('.popup-inner').removeClass('pop-expand');
            }
            if (Modernizr.mq('(max-width: 767px)')) {
                $('.lightbox-left').css('width', '100%');
                $('.lightbox-right').removeClass('in');
                $('.gallery-inner').css('width', '100%');
            }
        }else{
            $('.lightbox-left').css('width', '100%');
            $('.gallery-inner').css('width', '100%');
            $('.lightbox-left .lightbox-close').addClass('show');
            $('.lightbox-left .expand-icon').hide('show');
        }
    }

    $(window).on('load',function(){
        lightBoxSlide();
        popupResize();
    });

    $(window).on('resize', function () {
        popupResize();
    });

    function popForm_hide_show(){
        $('.expand-icon').on('click',function(){
            $('.lightbox-left .lightbox-close').toggleClass('show');
            var popupWidth = getPopupWidth();
            var popWidthTotal = (getPopupWidth()-60) - popupRightWidth;

            if(popupWidth >= 767){
                if($(this).hasClass('compress')){
                    $('.lightbox-right').addClass('in');
                    $('.lightbox-left').css('width', popWidthTotal);
                    $('.expand-icon').removeClass('compress');
                    $('.popup-inner').removeClass('pop-expand');
                }else{
                    $('.lightbox-left').css('width', '100%');
                    $('.lightbox-right').removeClass('in');
                    $('.expand-icon').addClass('compress');
                    $('.popup-inner').addClass('pop-expand');
                }
            }else if(popupWidth <= 767){
                $('.lightbox-left').css('width', '100%');

                if ($(this).hasClass('compress')) {
                    $('.lightbox-right').removeClass('in');
                    $('.expand-icon').removeClass('compress');

                } else {
                    $('.lightbox-right').addClass('in');
                    $('.expand-icon').addClass('compress');
                }
            }
        });
    }
    popForm_hide_show();

    function getPopupWidth() {
        return Math.max( $(window).width(), $(window).innerWidth());
    }
    function getPopupInnerWidth() {
        return Math.max( $('.popup-inner').width(), $('.popup-inner').innerWidth());
    }

})(jQuery);