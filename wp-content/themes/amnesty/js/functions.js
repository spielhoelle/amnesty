(function ($) {
    var body = document.getElementsByTagName('body')[0];
    $(document).ready(function (jQuery) {
        /**
         * slider
         */
        $('.slider').bxSlider({
            mode: 'fade',
            speed: 500,
            pause: 10000,
            nextText: '<i class="fa fa-angle-right"></i>',
            prevText: '<i class="fa fa-angle-left"></i>',
            auto: true,
            pagerCustom: '.custom-pager',

            onSlideAfter: function (currentSlideNumber, totalSlideQty, currentSlideHtmlObject) {
                $('.active-slide').removeClass('active-slide');
                $('.slider > figure').eq(currentSlideHtmlObject).addClass('active-slide')
            },
            onSliderLoad: function () {
                $('.slider > figure').eq(0).addClass('active-slide')
            },
        });


        /**
         * make nice page load effect
         */
        $('#page').removeClass('page-hidden');

        var size = 0;
        var menu = $('#primary-menu')
        $('#primary-menu').find('li').each(function () {
            size = size + $(this).width();
        });
        if (size > menu.width()) {
            menu.addClass('responsive');
        }

    });

}(jQuery));
