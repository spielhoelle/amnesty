(function ($) {
    var body = document.getElementsByTagName('body')[0];
    $(document).ready(function (jQuery) {
        /**
         * slider
         */
        $('#slideshow').bxSlider({
            mode: 'fade',
            speed: 500,
            pager: false,
            nextText: '<i class="fa fa-angle-right"></i>',
            prevText: '<i class="fa fa-angle-left"></i>',
            //auto: true,
            onSlideAfter: function (currentSlideNumber, totalSlideQty, currentSlideHtmlObject) {
                $('.active-slide').removeClass('active-slide');
                $('#slideshow > figure').eq(currentSlideHtmlObject).addClass('active-slide')
            },
            onSliderLoad: function () {
                $('#slideshow > figure').eq(0).addClass('active-slide')
            }
        });
    });

}(jQuery));
