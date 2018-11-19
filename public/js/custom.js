/*
 Theme Name: Houzez
 Description: Houzez
 Author: Houzez
 Author: Houzez
 Version: 1.0
 */

var nice = false;
(function($){
    "use strict";

    var houzez_rtl = false;

    $('[data-toggle="popover"]').popover({
        trigger: "hover",
        html: true
    });

    /* ------------------------------------------------------------------------ */
    /*  BODY LOAD
     /* ------------------------------------------------------------------------ */
    $(window).on('load',function(){
        jQuery('body').addClass('loaded');
    });

    /* ------------------------------------------------------------------------ */
    /*  INPUT PLUS MINUS
    /* ------------------------------------------------------------------------ */
    $('.btn-number').click(function(e){
        e.preventDefault();

        var fieldName = $(this).attr('data-field');
        var type      = $(this).attr('data-type');
        var input = $("input[name='"+fieldName+"']");
        var currentVal = parseInt(input.val());
        if (!isNaN(currentVal)) {
            if(type == 'minus') {

                if(currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                }
                if(parseInt(input.val()) == input.attr('min')) {
                    $(this).attr('disabled', true);
                }

            } else if(type == 'plus') {

                if(currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                }
                if(parseInt(input.val()) == input.attr('max')) {
                    $(this).attr('disabled', true);
                }

            }
        } else {
            input.val(0);
        }
    });
    $('.input-number').focusin(function(){
        $(this).data('oldValue', $(this).val());
    });
    $('.input-number').change(function() {

        var minValue =  parseInt($(this).attr('min'));
        var maxValue =  parseInt($(this).attr('max'));
        var valueCurrent = parseInt($(this).val());

        var name = $(this).attr('name');
        if(valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the minimum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        if(valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the maximum value was reached');
            $(this).val($(this).data('oldValue'));
        }


    });
    $(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    /* ------------------------------------------------------------------------ */
    /*  BOOTSTRAP SELECT PICKER
     /* ------------------------------------------------------------------------ */
    /*if($('.selectpicker').length > 0){
     $('.selectpicker').selectpicker({
     dropupAuto: false,
     //showIcon: true,
     });
     }*/

    /* ------------------------------------------------------------------------ */
    /*  IF HEADER OR SEARCH STICKY
    /* ------------------------------------------------------------------------ */
    var ifHeaderSticky = $('#header-section').data('sticky');
    var ifHeaderBottomSticky = $('#header-section .header-bottom').data('sticky');
    var ifAdvanceSearchSticky = $('.advance-search-header').data('sticky');

    if(ifHeaderSticky == 1 && ifAdvanceSearchSticky == 0){
        var stickyHeaderH = $('#header-section').innerHeight();
        var topMargin = stickyHeaderH;
    }
    if(ifAdvanceSearchSticky == 1 && ifHeaderSticky == 0){
        var stickyAdvanceSearchH = $('.advance-search-header').innerHeight();
        var topMargin = stickyAdvanceSearchH;
    }
    if(ifHeaderBottomSticky == 1 && ifAdvanceSearchSticky == 0){
        var stickyHeaderH = $('#header-section .header-bottom').innerHeight();
        var topMargin = stickyHeaderH;
    }

    if(ifAdvanceSearchSticky == 1 && ifHeaderBottomSticky == 0){
        var stickyAdvanceSearchH = $('.advance-search-header').innerHeight();
        var topMargin = stickyAdvanceSearchH;

    }
    if(ifAdvanceSearchSticky == 0 && ifHeaderBottomSticky == 0){
        var topMargin = 0;
    }
    if(ifHeaderSticky == 0 && ifAdvanceSearchSticky == 0){
        var topMargin = 0;
    }
    if($('#header-section:not([data-sticky])') && $('.advance-search-header:not([data-sticky])')){
        var topMargin = 0;
    }
    if($('#header-section .header-bottom:not([data-sticky])') && $('.advance-search-header:not([data-sticky])')){
        var topMargin = 0;
    }
    if(ifHeaderBottomSticky == 1 && $('.advance-search-header:not([data-sticky])')){
        var stickyHeaderH = $('#header-section .header-bottom').innerHeight();
        var topMargin = stickyHeaderH;
    }
    if($('#header-section .header-bottom:not([data-sticky])') && ifAdvanceSearchSticky == 1){
        var stickyAdvanceSearchH = $('.advance-search-header').innerHeight();
        var topMargin = stickyAdvanceSearchH;
    }
    if($('#header-section:not([data-sticky])') && ifAdvanceSearchSticky == 1){
        var stickyAdvanceSearchH = $('.advance-search-header').innerHeight();
        var topMargin = stickyAdvanceSearchH;
    }
    if(ifHeaderSticky == 1 && $('.advance-search-header:not([data-sticky])')){
        var stickyHeaderH = $('#header-section').innerHeight();
        var topMargin = stickyHeaderH;
    }

    if($('#header-section').hasClass('header-section-3') && ifHeaderBottomSticky == 1){
        var stickyHeaderH = $('#header-section .header-bottom').innerHeight();
        var topMargin = stickyHeaderH;
    }

    if($('#header-section').hasClass('header-section-3') && ifAdvanceSearchSticky == 1){
        var stickyAdvanceSearchH = $('.advance-search-header').innerHeight();
        var topMargin = stickyAdvanceSearchH;
    }

    if($('#header-section').hasClass('header-section-2') && ifHeaderBottomSticky == 1){
        var stickyHeaderH = $('#header-section .header-bottom').innerHeight();
        var topMargin = stickyHeaderH;
    }

    if($('#header-section').hasClass('header-section-2') && ifAdvanceSearchSticky == 1){
        var stickyAdvanceSearchH = $('.advance-search-header').innerHeight();
        var topMargin = stickyAdvanceSearchH;
    }

    /* ------------------------------------------------------------------------ */
    /*  PROPERTY MENU TARGET NAV
    /* ------------------------------------------------------------------------ */
    var propertyMenuH = $('.property-menu-wrap').innerHeight();
    if($('.detail-media').length) {
        $(".target").each(function () {
            $(this).on('click', function (e) {
                //var jump = $(this).attr("href");
                //var scrollto = ($(jump).offset().top);
                // scrollto = scrollto - (topMargin) - (propertyMenuH);
                // $("html, body").animate({scrollTop: scrollto}, {duration: 1000, easing: 'easeInOutExpo', queue: false});
                e.preventDefault();
            });
        });
    }
    if($('.detail-media').length) {
        $(window).on('scroll', function () {
            $('.target-block').each(function () {
                if ($(window).scrollTop() >= $(this).offset().top - (topMargin) - (propertyMenuH)) {
                    var id = $(this).attr('id');
                    $('.target').removeClass('active');
                    $('.target[href=#' + id + ']').addClass('active');
                } else if ($(window).scrollTop() <= 0) {
                    $('.target').removeClass('active');
                }
            });
        });
    }


    /* ------------------------------------------------------------------------ */
    /*  PROPERTY MENU STICKY
    /* ------------------------------------------------------------------------ */
    if($('.detail-media').length) {
        $(window).on('scroll', function () {
            if ($(window).scrollTop() >= $('.detail-media').offset().top + (200)) {
                $('.property-menu-wrap').css({top: topMargin}).fadeIn();
            } else if ($(window).scrollTop() <= $('.detail-media').offset().top + (200)) {
                $('.property-menu-wrap').css({top: topMargin}).fadeOut();
            }
        });
    }
    /* ------------------------------------------------------------------------ */
    /*  One page smooth scroll
     /* ------------------------------------------------------------------------ */
    $(function() {
        $('#header-section a[href*="#"]:not([href="#"])').click(function() {
            if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top
                    }, 1000);
                    return false;
                }
            }
        });
    });

    /* ------------------------------------------------------------------------ */
    /*  NICE SCROLL
     /* ------------------------------------------------------------------------ */
    /*var nice = $("html").niceScroll({
     //cursorcolor: "#666",
     scrollspeed: 50,
     mousescrollstep: 30,
     //boxzoom: false,
     //autohidemode: false,
     cursorborder: "0 solid #666",
     //cursorborderradius: "0",
     cursorwidth: 6,
     //background: "#666",
     //horizrailenabled: false
     });*/


    /* ------------------------------------------------------------------------ */
    /*  ADD COMMA TO VALUE
     /* ------------------------------------------------------------------------ */
    var addCommas = function(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
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

    if($( ".price-range-advanced").length >0) {
        $(".price-range-advanced").slider({
            range: true,
            min: 500,
            max: 5000,
            values: [500, 5000],
            slide: function (event, ui) {
                $(".min-price-range-hidden").val("$ " + addCommas(ui.values[0]));
                $(".max-price-range-hidden").val("$ " + addCommas(ui.values[1]));

                $(".min-price-range").text("$ " + addCommas(ui.values[0]));
                $(".max-price-range").text("$ " + addCommas(ui.values[1]));
            }
        });

        $(".min-price-range-hidden").val("$ " + addCommas($(".price-range-advanced").slider("values", 0)));
        $(".max-price-range-hidden").val("$ " + addCommas($(".price-range-advanced").slider("values", 1)));

        $(".min-price-range").text("$ " + addCommas($(".price-range-advanced").slider("values", 0)));
        $(".max-price-range").text("$ " + addCommas($(".price-range-advanced").slider("values", 1)));
    }

    /* ------------------------------------------------------------------------ */
    /*  HEADER STICKY
    /* ------------------------------------------------------------------------ */

        var header_main = $('#header-section').data('sticky');
        var header_inner = $('#header-section .header-bottom').data('sticky');
        var header_mobile = $('.header-mobile').data('sticky');
        var get_header_class = $('#header-section').attr('class');

        if(header_inner == 1){
            this_sticky($('#header-section .header-bottom'));

        }
        if(header_main == 1){
            this_sticky($('#header-section'));
        }
        if(header_mobile == 1){
            this_sticky($('.header-mobile'));
        }

        function this_sticky(ele){

            var header_position = ele.outerHeight();
            var sticky_nav = ele.clone().removeAttr('style').removeClass('houzez-header-transparent');
            var sticky_wrap = $(sticky_nav).wrap("<div class='sticky_nav'></div>").parent().addClass(get_header_class).removeClass('houzez-header-transparent');
            sticky_wrap = sticky_wrap.removeClass('header-transparent not-splash-header nav-left');
            //var sticky_wrap = $(sticky_nav).wrap("<div class='sticky_nav'></div>").parent();

            $('body').append( sticky_wrap );


            /*if($(sticky_wrap).hasClass('header-section-4')) {
                $('.sticky_nav .logo img').attr('src',HOUZEZ_ajaxcalls_vars.simple_logo);
            }*/

            function fix_header(){
                sticky_wrap.css( 'top', '0' );
            }

            $(window).on('scroll', function(){
                /*if($('#wpadminbar').length > 0) {
                    var admin_bar_height = $('#wpadminbar').outerHeight();
                    sticky_wrap.css( 'top', admin_bar_height );
                }*/
                if( $(window).scrollTop() >= ele.position().top + header_position ){
                    sticky_wrap.slideDown();
                }
                else{
                    sticky_wrap.fadeOut();
                }
            });

            fix_header();
            $(window).resize(function(){
                fix_header();
            });
        }

    /* ------------------------------------------------------------------------ */
    /*  ADVANCE SEARCH STICKY
    /* ------------------------------------------------------------------------ */
    function advancedSearchSticky() {
        if(getWindowWidth() > 991){
            var search = $('.advance-search-header');
            var thisHeight = $('.advance-search-header').outerHeight();
        }else{
            var search = $('.advanced-search-mobile');
            var thisHeight = $('.advanced-search-mobile').outerHeight();
        }
        if (!search.data('sticky')) {
            return;
        }

        if( $(".splash-search")[0] ) {
            var sr_sticky_top = $('.splash-search').offset().top;
            sr_sticky_top = sr_sticky_top + 200;
        } else {
            if(getWindowWidth() > 991){
                var sr_sticky_top = $('.advance-search-header').offset().top + 65;
            }else{
                var sr_sticky_top = $('.advanced-search-mobile').offset().top;
            }
        }

        if( sr_sticky_top == 0 ) {
            sr_sticky_top = $('#header-section').height();
        }

        $(window).scroll(function() {
            var scroll = $(window).scrollTop();
            var admin_nav = $('#wpadminbar').height() + 'px';

            if( admin_nav == 'nullpx' ) { admin_nav = '0px'; }

            if (scroll >= sr_sticky_top ) {
                search.addClass("advanced-search-sticky");
                search.css('top', admin_nav);
                $('#section-body').css('padding-top',thisHeight);
            } else {
                search.removeClass("advanced-search-sticky");
                search.removeAttr("style");
                $('#section-body').css('padding-top',0);
            }
        });
    }
    advancedSearchSticky();

    /* ------------------------------------------------------------------------ */
    /*  Date picker
     /* ------------------------------------------------------------------------ */
    if($('.input_date').length > 0) {
        $('.input_date').datetimepicker({
            format: 'YYYY-MM-DD',//'DD/MM/YYYY',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down",
                left: "fa fa-arrow-left"
            }
        });
    }

    /* ------------------------------------------------------------------------
     /*  parallax
     ------------------------------------------------------------------------- */
    if($('.banner-parallax').length) {
    }
        function enable_parallax(){
            if($('.banner-parallax').length) {
                if (getWindowWidth() > 767) {
                    $('.banner-inner').addClass('banner-parallax');
                } else {
                    $('.banner-inner').removeClass('banner-parallax');
                }
            }else{
                return false;
            }
        }

        enable_parallax();
        $(window).on('resize', function () {
            enable_parallax();
        });


    /* ------------------------------------------------------------------------ */
    /*  DETAIL LIGHT BOX SLIDE SHOW
     /* ------------------------------------------------------------------------ */
    if($("a[data-fancy^='property_video']").length > 0) {
        $("a[data-fancy^='property_video']").prettyPhoto({
            allow_resize: true,
            default_width: 900,
            default_height: 500,
            animation_speed: 'normal',
            theme: 'default',
            slideshow: 3000,
            autoplay_slideshow: false,
        });
    }

    /* ------------------------------------------------------------------------ */
    /*  Properties filter on My properties dashboard
     /* ------------------------------------------------------------------------ */
    $("#property_name").keyup(function(){

        // Retrieve the input field text and reset the count to zero
        var filter = $(this).val(), count = 0;

        // Loop through the comment list
        $(".my-property-listing .item-wrap").each(function(){

            // If the list item does not contain the text phrase fade it out
            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                $(this).fadeOut();

                // Show the list item if the phrase matches and increase the count by 1
            } else {
                $(this).show();
                count++;
            }
        });

        // Update the count
        var numberItems = count;
        $(".my-property-search button").text(count);
    });

    /* ------------------------------------------------------------------------ */
    /*	SEARCH TABER
     /* ------------------------------------------------------------------------ */
    $('.banner-search-tabs .search-tab').on('click',function(){
        if($(this).hasClass('active')!=true){
            $('.banner-search-tabs .search-tab').removeClass('active');
            $(this).addClass('active');
            $('.banner-search-taber .tab-pane').removeClass('active in');
            $('.banner-search-taber .tab-pane').eq($(this).index()).addClass('active').delay(5).queue(function(next){
                $(this).addClass('in');
                next();
            });
        }
    });

    /* ------------------------------------------------------------------------ */
     /* PROPERTY DETAIL TABBER
     / ------------------------------------------------------------------------ */
    $('.detail-tabs > li').on('click',function(){

        if($(this).hasClass('active')!=true){
            $('.detail-tabs > li').removeClass('active');
            $(this).addClass('active');
            $('.detail-content-tabber .tab-pane').removeClass('active in');
            $('.detail-content-tabber .tab-pane').eq($(this).index()).addClass('active in');
        }
    });

    /* ------------------------------------------------------------------------ */
    /* PROFILE DETAIL TABBER
    /* ------------------------------------------------------------------------ */
    $('.profile-tabs > li').on('click',function(){
        if($(this).hasClass('active')!=true){
            $('.profile-tabs > li').removeClass('active');
            $(this).addClass('active');
            $('.profile-tab-pane').removeClass('active in');
            $('.profile-tab-pane').eq($(this).index()).addClass('active in');
        }
    });

    /* ------------------------------------------------------------------------ */
    /*	LOGIN TABBER
     /* ------------------------------------------------------------------------ */
    function houzez_tabber(target){
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
    houzez_tabber('.widget');
    houzez_tabber('.footer-widget');
    houzez_tabber('.modal');

    /* ------------------------------------------------------------------------ */
    /*  ACCORDION ADD PROPERTY
    /* ------------------------------------------------------------------------ */

    $('.add-title-tab > .add-expand').click(function() {
        $(this).toggleClass('active');
        $(this).parent().next('.add-tab-content').slideToggle();
    });

    /* ------------------------------------------------------------------------ */
    /*  ACCORDION FAQS
     /* ------------------------------------------------------------------------ */

    $('.toggle-title').click(function() {
        $(this).toggleClass('active');
        $(this).next('.toggle-content').slideToggle();
    });


    /* ------------------------------------------------------------------------ */
    /*  ACCORDION
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
    /*  MAP VIEW TABBER
     /* ------------------------------------------------------------------------ */
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        e.target // newly activated tab
        e.relatedTarget // previous active tab
    });



    /* ------------------------------------------------------------------------ */
    /*  POST CARDS MASONRY
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
    /*  TOOLTIP
     /* ------------------------------------------------------------------------ */

    $('[data-toggle="tooltip"]').tooltip();

    /* ------------------------------------------------------------------------ */
    /*  SHARE TOOLTIP
     /* ------------------------------------------------------------------------ */
    $('.actions li').on('click',function(){

        if($(this).children('.share_tooltip').hasClass('in')){
            $(this).children('.share_tooltip').removeClass('in');
        }else{
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
    /*  SET COLUMNS HEIGHT
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
    /*$(window).load(function(){
     $('.post-card-description').matchHeight();
     });*/
    //}

    /* ------------------------------------------------------------------------ */
    /*  NAVIGATION
     /* ------------------------------------------------------------------------ */
    $('.navi ul li').each(function(){
        $(this).has('ul').addClass('has-child')
    });

    $('.navi ul .has-child').hover(
        function(){
            $(this).addClass("active");
        },
        function(){
            $(this).removeClass("active");
        }
    );

    /* ------------------------------------------------------------------------ */
    /*  CHANGE GRID LIST
     /* ------------------------------------------------------------------------ */
    $('.view-btn').on("click",function(){
        $('.view-btn').removeClass('active');
        $(this).addClass('active');
        if($(this).hasClass('btn-list')) {
            $('.property-listing').removeClass('grid-view grid-view-3-col').addClass('list-view');
        }
        else if($(this).hasClass('btn-grid')) {
            $('.property-listing').removeClass('list-view grid-view-3-col').addClass('grid-view');
        }
        else if($(this).hasClass('btn-grid-3-col')) {
            $('.property-listing').removeClass('list-view grid-view').addClass('grid-view grid-view-3-col');

        }
    });

    /* ------------------------------------------------------------------------ */
    /*  SECTION HEIGHT
    /* ------------------------------------------------------------------------ */
    function bg_image_size(size,url){
        var get_url = url,image;
        if(get_url) {
            // Remove url() or in case of Chrome url("")
            get_url = get_url.match(/^url\("?(.+?)"?\)$/);

            if (get_url[1]) {
                get_url = get_url[1];
                image = new Image();
                image.src = get_url;
                if (size == 'height') {
                    return image.height;
                } else {
                    return image.width;
                }
            }
        }
    }

    function setSectionHeight() {
        var section = $('body');
        var windowHeight = getWindowHeight();
        var windowWidth = getWindowWidth();

        var admin_bar_height = $('#wpadminbar').innerHeight();
        var innerHeaderH = $('.header-section').innerHeight();
        var outerHeaderH = $('#header-section').innerHeight();
        var mobileHeaderH = $('.header-mobile').innerHeight();
        var mobileSearchH = $('.advanced-search-mobile').innerHeight();
        var splashFootH = $('.splash-footer').innerHeight();
        var advancedSearchH = $('.advance-search-header').innerHeight();
        var topbarH = $('.top-bar').innerHeight();
        var searchH = (windowHeight-innerHeaderH)-splashFootH;

        $('.fave-screen-fix-inner').css( 'height', searchH );

        if($('.advance-search-header').length
            && !$('.advance-search-header').hasClass('search-hidden')
            && $('#header-section').length) {
            var fixHeight = (windowHeight-advancedSearchH)-outerHeaderH;
        }/*else{
            var fixHeight = windowHeight-outerHeaderH;
        }*/
        if($('.advance-search-header').hasClass('search-hidden')
            && $('#header-section').is('*')) {
            var fixHeight = windowHeight-outerHeaderH;
        }
        if($('#header-section').length){
            fixHeight = windowHeight-outerHeaderH;
        }
        if($('.header-mobile').length){
            fixHeight = windowHeight-mobileHeaderH;
        }
        if($('.header-mobile').length
            && $('#wpadminbar').length){
            fixHeight = windowHeight-mobileHeaderH;
        }
        if($('.header-mobile').length
            && $('.advanced-search-mobile').length){
            fixHeight = windowHeight-mobileHeaderH;
        }
        if($('.header-mobile').length
            && $('#wpadminbar').length
            && $('.advanced-search-mobile').length){
            fixHeight = windowHeight-mobileHeaderH;
        }
        if($('#header-section').length
            && $('#wpadminbar').length){
            fixHeight = (windowHeight-outerHeaderH)-admin_bar_height;
        }
        if($('#header-section').length
            && $('#wpadminbar').length
            && $('.advance-search-header').length
            && !$('.advance-search-header').hasClass('search-hidden')){
            fixHeight = ((windowHeight-outerHeaderH)-admin_bar_height)-advancedSearchH;
        }
        if($('#header-section').length
            && $('#wpadminbar').length
            && $('.advance-search-header').length
            && !$('.advance-search-header').hasClass('search-hidden')
            && $('.top-bar').length){
            fixHeight = (((windowHeight-outerHeaderH)-admin_bar_height)-advancedSearchH)-topbarH;
        }
        if($('#header-section').length
            && $('#wpadminbar').length
            && $('.advance-search-header').length
            && $('.advance-search-header').hasClass('search-hidden')
            && $('.top-bar').length){
            fixHeight = ((windowHeight-outerHeaderH)-admin_bar_height)-topbarH;
        }
        if($('#header-section').length
            && $('#wpadminbar').length
            && $('.top-bar').length){
            fixHeight = ((windowHeight-outerHeaderH)-admin_bar_height)-topbarH;
        }
        if($('#header-section').length
            && $('.top-bar').length){
            fixHeight = (windowHeight-outerHeaderH)-topbarH;
        }

        $('.fave-screen-fix').css( 'height', fixHeight );


        if(getWindowWidth() > 768){
            var image_url = $('.banner-inner').css('background-image');
            if(image_url != 'none'){
                var bg_height = $('.banner-parallax-fix').width() * bg_image_size('height',image_url) / bg_image_size('width',image_url);
                if(bg_height > getWindowHeight()){
                    $('.banner-parallax-fix').css( 'height', fixHeight );
                }else{
                    //alert(bg_height);
                    $('.banner-parallax-fix').css( 'height', bg_height-110 );
                }
            }else{
                $('.banner-parallax-fix').css( 'height', fixHeight );
            }
        }else{
            if($('.banner-inner').hasClass('banner-parallax-fix')){
                $('.banner-parallax-fix').css( 'height', 300 );
            }/*else{
                $('.banner-inner').css( 'height', 300 );
            }*/
        }
    }

    setSectionHeight();

    $(window).on('resize', function () {
        setSectionHeight();
        advancedSearchSticky();
    });
    
    $(window).on('load', function () {
        setSectionHeight();
    });

    function getWindowWidth() {
        return Math.max( $(window).width(), window.innerWidth);
    }

    function getWindowHeight() {
        return Math.max( $(window).height(), window.innerHeight);
    }

    /* ------------------------------------------------------------------------ */
    /*  ADVANCE DROPDOWN
     /* ------------------------------------------------------------------------ */
    $('.search-expand-btn').on('click',function(){
        $(this).toggleClass('active');
        if($(this).hasClass('active')==true)
        {
            $('.search-expandable .advanced-search').slideDown();
        }else
        {
            $('.search-expandable .advanced-search').add('.search-expandable .advance-fields').slideUp();
            $('.advance-btn').removeClass('active');

        }
    });
    $('.advanced-search .advance-btn').on('click',function(){
        $(this).toggleClass('active');
        if($(this).hasClass('active')==true)
        {
            $(this).closest('.advanced-search').find('.advance-fields').slideDown();
        }else
        {
            $(this).closest('.advanced-search').find('.advance-fields').slideUp();
        }
    });

    $('.advanced-search-mobile .advance-btn').on('click',function(){
        $(this).toggleClass('active');
        if($(this).hasClass('active')==true)
        {
            $(this).closest('.advanced-search-mobile').find('.advance-fields').slideDown();
        }else
        {
            $(this).closest('.advanced-search-mobile').find('.advance-fields').slideUp();
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
    /*  SLIDER initialized
    /* ------------------------------------------------------------------------ */
    var all_slider = $('#banner-slider, .carousel, .lightbox-slide, .property-widget-slider');
    all_slider.on('initialized.owl.carousel', function(event) {
        setTimeout(function(){
            all_slider.animate({opacity: 1}, 800);
            $('.gallery-area .slider-placeholder').remove();
        },800);
    });

    /* ------------------------------------------------------------------------ */
    /*  BANNER SLIDER
     /* ------------------------------------------------------------------------ */
    if($("#banner-slider").length > 0){
        var owl_main_slider = $('#banner-slider');

        owl_main_slider.owlCarousel({
            rtl: houzez_rtl,
            loop: true,
            dots: false,
            slideBy: 1,
            items:1,
            smartSpeed: 1000,
            nav: true,
            navText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
            addClassActive: true,
            callbacks: true,
        });
    }

    /* ------------------------------------------------------------------------ */
    /*  OWL CAROUSEL
    /* ------------------------------------------------------------------------ */

    if($("#properties-carousel-6").length > 0) {

        var houzez_crl_6 = $('#properties-carousel-6');

        houzez_crl_6.owlCarousel({
            rtl: houzez_rtl,
            loop: true,
            dots: true,
            items:6,
            slideBy: 6,
            nav: false,
            smartSpeed:400,
            responsive:{
                0: {
                    items: 1
                },
                320: {
                    items: 1
                },
                480: {
                    items: 2
                },
                768: {
                    items: 3
                },
                1000: {
                    items: 4
                },
                1280: {
                    items: 6
                }
            }
        });

        $('.btn-crl-6-prev').on('click',function() {
            houzez_crl_6.trigger('prev.owl.carousel',[400])
        });
        $('.btn-crl-6-next').on('click',function() {
            houzez_crl_6.trigger('next.owl.carousel',[400])
        });
    }
    if($("#properties-carousel-4").length > 0) {

        var houzez_crl_4 = $('#properties-carousel-4');

        houzez_crl_4.owlCarousel({
            rtl: houzez_rtl,
            loop: true,
            dots: true,
            items:4,
            slideBy: 1,
            nav: false,
            smartSpeed:400,
            responsive:{
                0: {
                    items: 1
                },
                320: {
                    items: 1
                },
                480: {
                    items: 1
                },
                767: {
                    items: 2
                },
                991: {
                    items: 4
                }
            }
        });

        $('.btn-crl-4-prev').on('click',function() {
            houzez_crl_4.trigger('prev.owl.carousel',[400])
        });
        $('.btn-crl-4-next').on('click',function() {
            houzez_crl_4.trigger('next.owl.carousel',[400])
        });
    }
    if($("#properties-carousel-3").length > 0) {

         var houzez_crl_3 = $('#properties-carousel-3');

         houzez_crl_3.owlCarousel({
             rtl: houzez_rtl,
             loop: true,
             dots: true,
             items:3,
             slideBy: 1,
             nav: false,
             smartSpeed:400,
             responsive:{
                 0: {
                     items: 1
                 },
                 320: {
                     items: 1
                 },
                 480: {
                     items: 1
                 },
                 767: {
                     items: 2
                 },
                 991: {
                     items: 3
                 }
             }
         });

         $('.btn-crl-3-prev').on('click',function() {
             houzez_crl_3.trigger('prev.owl.carousel',[400])
         });
         $('.btn-crl-3-next').on('click',function() {
             houzez_crl_3.trigger('next.owl.carousel',[400])
         });
    }

    if($("#properties-carousel-2").length > 0) {

        var houzez_crl_2 = $('#properties-carousel-2');

        houzez_crl_2.owlCarousel({
          rtl: houzez_rtl,
          loop: true,
          dots: true,
          items:2,
          slideBy: 1,
          nav: false,
          smartSpeed:400,
          responsive:{
              0: {
                  items: 1
              },
              320: {
                  items: 1
              },
              480: {
                  items: 1
              },
              767: {
                  items: 2
              }
          }
        });

        $('.btn-crl-2-prev').on('click',function() {
            houzez_crl_2.trigger('prev.owl.carousel',[400])
        });
        $('.btn-crl-2-next').on('click',function() {
            houzez_crl_2.trigger('next.owl.carousel',[400])
        });
    }
    if($("#properties-carousel-1").length > 0) {

       var houzez_crl_1 = $('#properties-carousel-1');

        houzez_crl_1.owlCarousel({
           rtl: houzez_rtl,
           loop: true,
           dots: true,
           items:1,
           slideBy: 1,
           nav: false,
           smartSpeed:400,
       });

       $('.btn-crl-1-prev').on('click',function() {
           houzez_crl_1.trigger('prev.owl.carousel',[400])
       });
       $('.btn-crl-1-next').on('click',function() {
           houzez_crl_1.trigger('next.owl.carousel',[400])
       });
    }
    if($(".properties-carousel-grid-1").length > 0) {

        var houzez_crl_pprt_1 = $('.properties-carousel-grid-1');

        houzez_crl_pprt_1.owlCarousel({
            rtl: houzez_rtl,
            loop: true,
            dots: true,
            items:3,
            slideBy: 1,
            nav: false,
            smartSpeed:400,
            responsive:{
                0: {
                    items: 1
                },
                320: {
                    items: 1
                },
                480: {
                    items: 1
                },
                767: {
                    items: 2
                },
                991: {
                    items: 3
                }
            }
        });

        $('.btn-crl-pprt-1-prev').on('click',function() {
            houzez_crl_pprt_1.trigger('prev.owl.carousel',[400])
        });
        $('.btn-crl-pprt-1-next').on('click',function() {
            houzez_crl_pprt_1.trigger('next.owl.carousel',[400])
        });
    }
    if($(".properties-carousel-grid-2").length > 0) {

        var houzez_crl_pprt_2 = $('.properties-carousel-grid-2');

        houzez_crl_pprt_2.owlCarousel({
            rtl: houzez_rtl,
            loop: true,
            dots: true,
            items:3,
            slideBy: 1,
            nav: false,
            smartSpeed:400,
            responsive:{
                0: {
                    items: 1
                },
                320: {
                    items: 1
                },
                480: {
                    items: 1
                },
                767: {
                    items: 2
                },
                991: {
                    items: 3
                }
            }
        });

        $('.btn-crl-pprt-2-prev').on('click',function() {
            houzez_crl_pprt_2.trigger('prev.owl.carousel',[400])
        });
        $('.btn-crl-pprt-2-next').on('click',function() {
            houzez_crl_pprt_2.trigger('next.owl.carousel',[400])
        });
    }

    if($("#carousel-post-card").length > 0) {

        var houzez_crl_post_card = $('#carousel-post-card');

        houzez_crl_post_card.owlCarousel({
            rtl: houzez_rtl,
            loop: true,
            dots: true,
            slideBy: 1,
            nav: false,
            responsive:{
                0: {
                    items: 1
                },
                320: {
                    items: 1
                },
                480: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1000: {
                    items: 3
                },
                1280: {
                    items: 4
                }
            }
        });

        $('.btn-crl-post-card-prev').on('click',function() {
            houzez_crl_post_card.trigger('prev.owl.carousel',[700])
        });
        $('.btn-crl-post-card-next').on('click',function() {
            houzez_crl_post_card.trigger('next.owl.carousel',[700])
        });

    }
    if($("#carousel-post-card-block").length > 0) {

        var houzez_crl_post_card_block = $('#carousel-post-card-block');

        houzez_crl_post_card_block.owlCarousel({
            rtl: houzez_rtl,
            loop: true,
            dots: true,
            slideBy: 1,
            nav: false,
            responsive:{
                0: {
                    items: 1
                },
                320: {
                    items: 1
                },
                480: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1000: {
                    items: 3
                },
                1280: {
                    items: 4
                }
            }
        });

        $('.btn-crl-card-block-prev').on('click',function() {
            houzez_crl_post_card_block.trigger('prev.owl.carousel',[700])
        });
        $('.btn-crl-card-block-next').on('click',function() {
            houzez_crl_post_card_block.trigger('next.owl.carousel',[700])
        });

    }

    if($("#testimonial-carousel").length > 0) {
        var houzez_crl_testi = $('#testimonial-carousel');

        houzez_crl_testi.owlCarousel({
            rtl: houzez_rtl,
            loop: true,
            dots: true,
            items:1,
            slideBy: 1,
            nav: true,
            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            smartSpeed:400,
        });

    }
    if($("#agents-carousel").length > 0){

        var houzez_crl_agents = $('#agents-carousel');
        houzez_crl_agents.owlCarousel({
            rtl: houzez_rtl,
            loop: true,
            dots: true,
            slideBy: 1,
            nav: false,
            smartSpeed:400,
            responsive:{
                0: {
                    items: 1
                },
                320: {
                    items: 1
                },
                480: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1000: {
                    items: 3
                },
                1280: {
                    items: 4
                }
            }
        });

        $('.btn-crl-agents-prev').on('click',function() {
            houzez_crl_agents.trigger('prev.owl.carousel',[700])
        });
        $('.btn-crl-agents-next').on('click',function() {
            houzez_crl_agents.trigger('next.owl.carousel',[700])
        });

    }
    if($("#partner-carousel").length > 0) {

        $("#partner-carousel").owlCarousel({
            rtl: houzez_rtl,
            loop: true,
            dots: true,
            slideBy: 2,
            nav:false,
            responsive:{
                0: {
                    items: 1
                },
                320: {
                    items: 1
                },
                480: {
                    items: 3
                },
                768: {
                    items: 4
                },
                992: {
                    items: 4
                }
            }
        });

        $('.btn-prev-partners').on('click',function() {
            $("#partner-carousel").trigger('prev.owl.carousel',[700])
        });
        $('.btn-next-partners').on('click',function() {
            $("#partner-carousel").trigger('next.owl.carousel', [700])
        });

    }

    if($(".property-widget-slider").length > 0) {
        $('.property-widget-slider').owlCarousel({
            rtl: houzez_rtl,
            dots: true,
            items: 1,
            smartSpeed: 700,
            slideBy: 1,
            nav: true,
            navText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
        });
    }

    /* ------------------------------------------------------------------------ */
    /*  SLIDER FOR DETAIL PAGE
    /* ------------------------------------------------------------------------ */

    function houzez_detail_slider_main_settings() {
        return {
            speed: 500,
            autoplay: false,
            autoplaySpeed: 4000,
            rtl: houzez_rtl,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            //fade: true,
            asNavFor: '.slideshow-nav'
        }
    };
    function houzez_detail_slider_nav_settings() {
        return {
            speed: 500,
            autoplay: false,
            autoplaySpeed: 4000,
            rtl: houzez_rtl,
            slidesToShow: 13,
            slidesToScroll: 1,
            asNavFor: '.slide',
            arrows: false,
            dots: false,
            centerMode: true,
            focusOnSelect: true
        }
    };

    function property_detail_slideshow() {
        $('.slide').slick(houzez_detail_slider_main_settings());
        $('.slideshow-nav').slick(houzez_detail_slider_nav_settings());
    };
    if($('.slide').length){
        property_detail_slideshow();
    }

    /* ------------------------------------------------------------------------ */
    /*  Change listing fee for featured
     /* ------------------------------------------------------------------------ */
    $('.prop_featured').change( function() {
        var parent = $(this).parents('table');
        var price_regular  = parseFloat( parent.find('.submission_price').text() );
        var price_featured = parseFloat( parent.find('.submission_featured_price').text() );

        var total_price = price_regular+price_featured;
        if( $(this).is(':checked') ) {
            parent.find('.submission_total_price').text(total_price);
        } else {
            parent.find('.submission_total_price').text(price_regular);
        }

    });

    /* ------------------------------------------------------------------------ /
     /* PAY DROPDOWN
     / ------------------------------------------------------------------------ */
    $('.my-actions .pay-btn').on('click', function (event) {
        if($(this).parent().hasClass("open")!=true) {
            $('.my-actions .pay-btn').parent().removeClass("open");
            $(this).parent().addClass("open");
        } else {
            $(this).parent().removeClass("open");
        }
    });
    $('body').on('click', function (e) {
        if (!$('.my-actions .pay-btn').is(e.target) && $('.my-actions .pay-btn').has(e.target).length === 0 && $('.open').has(e.target).length === 0) {
            $('.my-actions .pay-btn').parent().removeClass('open');
        }
    });

    /*-----------------------------------------------------------------------------------*/
    /* PROPERTIES SORTING
     /*-----------------------------------------------------------------------------------*/
    function insertParam(key, value) {
        key = encodeURI(key);
        value = encodeURI(value);

        // get querystring , remove (?) and covernt into array
        var qrp = document.location.search.substr(1).split('&');

        // get qrp array length
        var i = qrp.length;
        var j;
        while (i--) {
            //covert query strings into array for check key and value
            j = qrp[i].split('=');

            // if find key and value then join
            if (j[0] == key) {
                j[1] = value;
                qrp[i] = j.join('=');
                break;
            }
        }

        if (i < 0) {
            qrp[qrp.length] = [key, value].join('=');
        }
        // reload the page
        document.location.search = qrp.join('&');

    }

    $('#sort_properties').on('change', function() {
        var key = 'sortby';
        var value = $(this).val();
        insertParam( key, value );
    });

    $('#hmap_keyword, #hmap_location, #hmap_status, #hmap_type, #hmap_bedrooms, #hmap_bathrooms, #hmap_min-price, #hmap_max-price, #hmap_min-area, #hmap_max-area').on('change', function() {
        var key = $(this).data('search');
        var value = $(this).val();
        insertParam( key, value );
    });

    /* ------------------------------------------------------------------------ */
    /*  ACCOUNT DROPDOWN
     /* ------------------------------------------------------------------------ */

    function accountDropdown(){
        if ($(window).width() < 992){
            $(".account-action > li").off('mouseenter'); //Remove mouseenter event listeners
            $(".account-action > li").off('mouseleave'); //Remove mouseleave event listeners
            $('.account-action > li').on('click',function(e){
                //e.preventDefault();
                //$('.nav-trigger').removeClass('mobile-open');
                if($(this).hasClass('active')){
                    $(this).removeClass('active');
                }else{
                    //$('.account-action > li').removeClass('active');
                    $(this).addClass('active');
                }
            });
        }
        if ($(window).width() > 992){
            $(".account-action > li").off('click'); //Remove click event listeners
            $(".account-action > li").on({
                mouseenter: function (e) {
                    //e.preventDefault();
                    //$('.nav-trigger').removeClass('mobile-open');
                    $(this).addClass('active');
                },
                mouseleave: function (e) {
                    //e.preventDefault();
                    $(this).removeClass('active');
                }
            });
        }
    }
    var id;
    $(window).resize(function() {
        clearTimeout(id);
        id = setTimeout(accountDropdown, 0);
    });

    accountDropdown();

    /* ------------------------------------------------------------------------ */
    /*  MOBILE MENU
     /* ------------------------------------------------------------------------ */
    function mobileMenu(menu_html,menu_place){
        var siteMenu = $(menu_html).html();
        $(menu_place).html(siteMenu);

        $(menu_place+' ul li').each(function(){
            $(this).has('ul').addClass('has-child');
        });

        $(menu_place+' ul .has-child').append('<span class="expand-me"></span>');

        $(menu_place+' .expand-me').on('click',function(){
            var parent = $(this).parent('li');
            if(parent.hasClass('active')==true){
                parent.removeClass('active');
                parent.children('ul').slideUp();
            }else{
                parent.addClass('active');
                parent.children('ul').slideDown();
            }
        });
    }
    mobileMenu('.main-nav','.main-nav-dropdown');
    mobileMenu('.top-nav','.top-nav-dropdown');
    mobileMenu('.top-nav','.top-nav-dropdown');

    $('.nav-trigger').on('click',function(){
        if($(this).hasClass('mobile-open')){
            $(this).removeClass('mobile-open');
        }else{
            $(this).addClass('mobile-open');
        }
    });

    function element_hide(ele,ele_class){
        $(document).mouseup(function (e)
        {
            var nav_trigger = $(ele);

            if (!nav_trigger.is(e.target) // if the target of the click isn't the container...
                && nav_trigger.has(e.target).length === 0 // ... nor a descendant of the container
                && !$('.nav-dropdown').is(e.target)
                && $('.nav-dropdown').has(e.target).length === 0
                && !$('.account-dropdown').is(e.target)
                && $('.account-dropdown').has(e.target).length === 0)
            {
                $(ele).removeClass(ele_class);
            }
        });
    }

    element_hide('.header-mobile .nav-trigger','mobile-open');
    element_hide('.top-bar .nav-trigger','mobile-open');
    element_hide('.account-action li','active');

    /* ------------------------------------------------------------------------ */
    /*  MORTGAGE CALCULATOR SHOW RESULTS 
    /* ------------------------------------------------------------------------ */
    $('.show-morg').on('click',function () {
       if($(this).hasClass('active')){
           $('.morg-summery').slideUp();
           $(this).removeClass('active');
       }else{
           $('.morg-summery').slideDown();
           $(this).addClass('active');
       }
    });

    /* ------------------------------------------------------------------------ */
    /*  DETAIL LIGHT BOX SLIDE SHOW
     /* ------------------------------------------------------------------------ */
    function lightBoxSlide() {
        $('.lightbox-slide').show(function(){
            $('.lightbox-slide').owlCarousel({
                autoPlay : 3000,
                rtl: houzez_rtl,
                dots: false,
                items: 1,
                smartSpeed: 700,
                slideBy: 1,
                nav: true,
                stopOnHover : true,
                autoHeight : true,
                navText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
            });
        });
    }
    $('.lightbox-slide').on('resized.owl.carousel', function (event) {
        var $this = $(this);
        $this.find('.owl-height').css('height', $this.find('.owl-item.active').height());
    });
    /* ------------------------------------------------------------------------ */
    /*  LIGHT BOX
     /* ------------------------------------------------------------------------ */
// contactform

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
            if (Modernizr.mq('(max-width: 1024px)')) {
                $('.lightbox-left').css('width', '100%');
                $('.lightbox-right').removeClass('in');
                $('.gallery-inner').css('width', '100%');
                $('.expand-icon').addClass('compress');
                $('.lightbox-left .lightbox-close').addClass('show');
            }
        }else{
            $('.lightbox-left').css('width', '100%');
            $('.gallery-inner').css('width', '100%');
            $('.lightbox-left .lightbox-close').addClass('show');
            $('.lightbox-left .expand-icon').hide('show');
        }
    }
    popupResize();
    function popForm_hide_show(){
        $('.expand-icon').on('click',function(){
            $('.lightbox-left .lightbox-close').toggleClass('show');
            var popupWidth = getPopupWidth();
            var popWidthTotal = (getPopupWidth()-60) - popupRightWidth;

            if(popupWidth >= 1024){
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
            }
            if(popupWidth <= 1024/* && popupWidth >= 768*/){
                //$('.lightbox-left').css('width', '100%');

                if ($(this).hasClass('compress')) {
                    $('.lightbox-right').addClass('in');
                    $('.lightbox-left').css('width', popWidthTotal);
                    $('.expand-icon').removeClass('compress');

                } else {
                    $('.lightbox-left').css('width', '100%');
                    $('.lightbox-right').removeClass('in');
                    $('.expand-icon').addClass('compress');
                }
            }
            if(popupWidth < 768){
                $('.lightbox-left').css('width', '100%');
                //alert('ok');
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

    var clicked="desktop";
    var t={ desktop:"100%",tabletlandscape:1040,tabletportrait:788,mobilelandscape:500,mobileportrait:340,placebo:0 };

    jQuery(".bar-menu .screen-view-tab").on("click",function(e){
        e.preventDefault();
        var el=jQuery(this);
        for(var device in t){
            console.log(device);console.log(t[device]);
            if(el.hasClass(device)){
                clicked=device;
                jQuery("#frame-main, #project-iframe").width(t[device]).attr('width', t[device]);
                if(clicked==device){
                    //if ( !el.closest('#device-select').length ) {
                        jQuery(".bar-menu .screen-view-tab").removeClass("active");
                        el.addClass("active");
                        //var dIcon = el.find('.icon').clone();
                        //$('.selected-device').html(dIcon);
                        //$('#device-select').removeClass("active");
                    //}

                }
            }
        }
    });

    function resizeThemeFrame(){
        var pr_bar_H = $(".purchase-bar-wrap").innerHeight();
        if ( $(".purchase-bar-wrap").length ) {
            $("#project-iframe").attr("height", getWindowHeight()-pr_bar_H+"px");
        } else {
            $("#project-iframe").attr("height", getWindowHeight()+"px");
        }
    }
    resizeThemeFrame();

    $(window).on('load',function(){
        lightBoxSlide();
        popupResize();

    });

    $(window).on('resize', function () {
        popupResize();
        resizeThemeFrame()
    });

    $( document ).ready(function() {
        $('.tagcloud a').removeAttr('style');
    });



    /* ------------------------------------------------------------------------ */
    /*  Contact Us - 10-28-2018 Evelio
     /* ------------------------------------------------------------------------ */
    $('.btnContactus').on('click', function (e) {
        e.preventDefault();

        let formData = new FormData();
        let getData = $('#contact_form').find(':input').serializeArray();

        formData.append( 'form_name', 'contact_form');  
        $.each(getData, function(i, field){
            formData.append( field.name, field.value);  
            console.log('jdata', field.name, field.value );
        });
        console.log( 'Id: ', this.id);

        $.ajax({
          url: 'links_property/modal_post_ajax',
          method:"POST",
          data: formData,
          contentType: false,
          cache: false,
          processData:false,      
          success : function(data){
            // console.log( 'Return Data:......  ', data);
            let response = JSON.parse( data );
            // console.log( 'Return Data:......  ', response);

            if( response['success'] == 1 ){
alert('Contact Us was submitted......');

            } else {
              console.log('response',response['errors_array']);
              let error_message = response['errors_array'];
              for ( var key in error_message ) {
                // console.log('key: ', key);
                if (error_message.hasOwnProperty(key)){
                  if( key !== 'contains' ){
                    $('.'+key).html(error_message[key]);
                  }  
                }
              }
            } 
          }

        });
    });


    /* ------------------------------------------------------------------------ */
    /*  Modal - 04-29-2018 Evelio
     /* ------------------------------------------------------------------------ */
    $('.btnSubmit').on('click', function (e) {
        e.preventDefault();

        let formData = new FormData();
        let getData = $('#pop-login').find(':input').serializeArray();
        formData.append( 'form_name', 'pop-login');          
        $.each(getData, function(i, field){
            formData.append( field.name, field.value);  
            // console.log('jdata', field.name, field.value );
        });
            
        $.ajax({
          url: 'links_property/modal_post_ajax',
          method:"POST",
          data: formData,
          contentType: false,
          cache: false,
          processData:false,      
          success : function(data){
            // console.log( 'Return Data:......  ', data);
            let response = JSON.parse( data );
            // console.log( 'Return Data:......  ', response);

            if( response['success'] == 1 ){
                $('#pop-login').modal('toggle');

                $('#pop-login').on('hidden.bs.modal', function (e) {
                  $(this)
                    .find("input,textarea,select")
                       .val('')
                       .end()
                    .find("input[type=checkbox], input[type=radio]")
                       .prop("checked", "")
                       .end();
                })                

            } else {
              console.log('response',response['errors_array']);
              let error_message = response['errors_array'];
              for ( var key in error_message ) {
                // console.log('key: ', key);
                if (error_message.hasOwnProperty(key)){
                  if( key !== 'contains' ){
                    $('.'+key).html(error_message[key]);
                  }  
                }
              }
            } 
          }

        });
    });

})(jQuery);


/* Removed by Evelio. Ask Andy if needed */
// $(document).ready(function() {
//     if($('#contact_form').length){
//         $('#contact_form').bootstrapValidator({
//             // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
//             message: 'This value is not valid',
//             //framework: 'bootstrap',
//             feedbackIcons: {
//                 valid: 'fa fa-ok',
//                 invalid: 'fa fa-remove',
//                 validating: 'fa fa-refresh'
//             },
//             fields: {
//                 phone: {
//                     validators: {
//                         notEmpty: {
//                             message: 'The Name is required and cannot be empty'
//                         }
//                     }
//                 },
//                 email: {
//                     validators: {
//                         notEmpty: {
//                             message: 'The email address is required'
//                         },
//                         emailAddress: {
//                             message: 'The email address is not valid'
//                         }
//                     }
//                 },
//                 message: {
//                     validators: {
//                         notEmpty: {
//                             message: 'The Message is required and cannot be empty'
//                         }
//                     }
//                 }
//             }
//         })/*.on('success.form.bv', function(e) {
//          $('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
//          $('#contact_form').data('bootstrapValidator').resetForm();

//          // Prevent form submission
//          e.preventDefault();

//          // Get the form instance
//          var $form = $(e.target);

//          // Get the BootstrapValidator instance
//          var bv = $form.data('bootstrapValidator');

//          // Use Ajax to submit form data
//          $.post($form.attr('action'), $form.serialize(), function(result) {
//          console.log(result);
//          }, 'json');
//          });*/
//     }

// });


