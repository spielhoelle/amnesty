(function ($) {
    var body = document.getElementsByTagName('body')[0];
    $(document).ready(function (jQuery) {
        /**
         * slider
         */
        $('.slider').bxSlider({
            controls:    false,
            mode:        'fade',
            speed:       500,
            pause:       10000,
            nextText:    '<i class="fa fa-angle-right"></i>',
            prevText:    '<i class="fa fa-angle-left"></i>',
            auto:        true,
            pagerCustom: '.custom-pager',

            onSlideAfter: function (currentSlideNumber, totalSlideQty, currentSlideHtmlObject) {
                $('.active-slide').removeClass('active-slide');
                $('.slider > figure').eq(currentSlideHtmlObject).addClass('active-slide')
            },
            onSliderLoad: function () {
                $('.slider > figure').eq(0).addClass('active-slide')
            }
        });


        /**
         * make nice page load effect
         */
        $('#page').removeClass('page-hidden');


        /**
         * show newsletter popup after X seconds and just once overall
         */
        if (localStorage.getItem('popState') != 'shown' && jQuery(window).width() > 1200) {

            setTimeout(function () {
                $(".site-footer > #nlpopup").addClass('active')
            }, 20000);

            localStorage.setItem('popState', 'shown')
        }

        //close functions
        $('#nlpopup .close').click(function (e) // You are clicking the close button
        {
            $(".site-footer > #nlpopup").fadeOut().removeClass("active");
        });

        $(document).keydown(function(e) {
            // ESCAPE key pressed
            if (e.keyCode == 27) {
              $(".site-footer > #nlpopup").fadeOut().removeClass("active");
            }
        });

        $("body").click(function () {
            $(".site-footer > #nlpopup").fadeOut().removeClass("active");
        });

//      Prevent events from getting pass .popup
        $("#nlpopup .wpcf7").click(function (e) {
            e.stopPropagation();
        });


        $('#menu-search').click(function(){
          if($('#menu-search .search-form').is(':visible')){
              $('#menu-search .search-form').hide()
            } else {
            $('#menu-search .search-form').show()
          }
        })

        $('body').click(function(){
          if($('#menu-search .search-form').is(':visible')){
            $('#menu-search .search-form').hide()
          }
        })

        $('#menu-search').click(function (e) {
            e.stopPropagation();
        });


    });

}(jQuery));
