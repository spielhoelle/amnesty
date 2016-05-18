(function($) {
    var body = document.getElementsByTagName('body')[0];
    $(document).ready(function(jQuery) {
        $('.slider').bxSlider({
            controls: false,
            mode: 'fade',
            speed: 500,
            pause: 10000,
            nextText: '<i class="fa fa-angle-right"></i>',
            prevText: '<i class="fa fa-angle-left"></i>',
            auto: true,
            pagerCustom: '.custom-pager',

            onSlideAfter: function(currentSlideNumber, totalSlideQty, currentSlideHtmlObject) {
                $('.active-slide').removeClass('active-slide');
                $('.slider > figure').eq(currentSlideHtmlObject).addClass('active-slide')
            },
            onSliderLoad: function() {
                $('.slider > figure').eq(0).addClass('active-slide')
            }
        });




        /**
         * show newsletter popup after X seconds and just once overall
         */
        if (localStorage.getItem('popState') != 'shown' && jQuery(window).width() > 1200) {
            setTimeout(function() {
                openPopup()
            }, 15000);
            localStorage.setItem('popState', 'shown')
        }

        $('#nlpopup .close').click(function(e) {
            closePopup();
        });

        $(document).keydown(function(e) {
            if (e.keyCode == 27) {
                closePopup()
            }
        });

        $("body").click(function() {
            closePopup()
        });


        $("#nlpopup .wpcf7").click(function(e) {
            e.stopPropagation();
        });

        closePopup = function() {
          $(".site-footer > #nlpopup").fadeOut().removeClass("active");
          $(body).removeClass('nl-open')
        }
        openPopup = function() {
          $(".site-footer > #nlpopup").addClass('active')
          $(body).addClass('nl-open')
        }

        /**
         * header navigation SEARCH
         */
        $('#menu-search .fa').click(function() {
            if ($('#menu-search .search-form').is(':visible')) {
                $('#menu-search .search-form').hide()
            } else {
                $('#menu-search .search-form').show()
                $('#menu-search .search-form .search-field').focus()

            }
        })

        $('body').click(function() {
            if ($('#menu-search .search-form').is(':visible')) {
                $('#menu-search .search-form').hide()
            }
        })

        $('#menu-search').click(function(e) {
            e.stopPropagation();
        });

        //contactform spinner
        $('.wpcf7 input[type="submit"]').parent().append('<i class="fa fa-spinner fa-2x fa-spin"></i>')
        $('.wpcf7 input[type="submit"]').on('click', function(){
            $('.wpcf7 .fa-spinner').css({'visibility': 'visible'})
        })

        /**
         * make nice page load effect
         */
        $('#page').removeClass('page-hidden');
    });

    $(document).on('mailsent.wpcf7', function() {
      $('.wpcf7 .fa-spinner').removeAttr('style')
      setTimeout(function() {
          closePopup()
      }, 2000);
    })

}(jQuery));
