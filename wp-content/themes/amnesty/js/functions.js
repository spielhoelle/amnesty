(function($) {
    var body = document.getElementsByTagName('body')[0];

    $(document).ready(function(jQuery) {

      var slider = $('.slider').bxSlider({
          controls: true,
          pager: false,
          mode: 'fade',
          speed: 500,
          pause: 10000,
          nextText: '<i class="fa fa-angle-right"></i>',
          prevText: '<i class="fa fa-angle-left"></i>',
          auto: false,
          onSlideAfter: function(currentSlideNumber, totalSlideQty, currentSlideHtmlObject) {
              $('.active-slide').removeClass('active-slide');
              $('.slider > figure').eq(currentSlideHtmlObject).addClass('active-slide')
          },
          onSliderLoad: function() {
            $('.slider > figure').eq(0).addClass('active-slide')
            $('.slider > figure').css({'height': "100%"})
          }
      });



      function debounce(func, wait, immediate) {
      	var timeout;
      	return function() {
      		var context = this, args = arguments;
      		var later = function() {
      			timeout = null;
      			if (!immediate) func.apply(context, args);
      		};
      		var callNow = immediate && !timeout;
      		clearTimeout(timeout);
      		timeout = setTimeout(later, wait);
      		if (callNow) func.apply(context, args);
      	};
      };

      var myEfficientFn = debounce(function() {

        var maxHeight = 0;
        $(".bx-viewport .slide").each(function(){
           $(this).css({'height': "auto"})
           var thisH = $(this).height()
           if (thisH > maxHeight) { maxHeight = thisH; }
        });

        $('.bx-viewport').css("height",maxHeight);
        $('.slider > figure').css({'height': "100%"})

      }, 500);

      $(window).on('resize', myEfficientFn)




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
        $('.wpcf7 input[type="submit"]').parent().append('<i class="fa fa-circle-o-notch fa-2x fa-spin"></i>')
        $('.wpcf7 input[type="submit"]').on('click', function(){
            $('.wpcf7 .fa-circle-o-notch').css({'visibility': 'visible'})
        })

        /**
         * make nice page load effect
         */
        $('#page').removeClass('page-hidden');
    });




    $(document).on('mailsent.wpcf7', function() {
      $('.wpcf7 .fa-circle-o-notch').removeAttr('style')
      setTimeout(function() {
          closePopup()
      }, 2000);
    })

}(jQuery));
