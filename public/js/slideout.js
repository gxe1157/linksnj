
$(function () {

    var special = ['reveal', 'top', 'boring', 'perspective', 'extra-pop'];

    // Toggle Nav on Click
    $('#popout-menu').click(function () {

        var transitionClass = $(this).data('transition');

        if ($.inArray(transitionClass, special) > -1) {
            $('body').removeClass();
            $('body').addClass(transitionClass);
        } else {
            $('body').removeClass();
            $('#site-canvas').removeClass();
            $('#site-canvas').addClass(transitionClass);
        }

        $('#site-wrapper').toggleClass('show-nav');

        if ($('#site-wrapper').hasClass('show-nav')) {
            $(this).find(".svg-inline--fa").attr("class", "svg-inline--fa ml-16 fa-times fa-w-14");
        } else {
            $(this).find(".svg-inline--fa").attr("class", "svg-inline--fa ml-16 fa-bars fa-w-14");
        }

        return false;

    });

});