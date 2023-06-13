(function($) {
    $(document).ready(function(jQuery) {
      
      delay = 15000;
      if (localStorage.getItem('popState') != 'shown' && jQuery(window).width() > 800) {
          setTimeout(function() {
              openPopup()
          }, delay);
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

      $('body').click(function() {
          closePopup()
      });


      $("#nlpopup .wpcf7, #nlpopup .textcontainer").click(function(e) {
          e.stopPropagation();
      });

      closePopup = function() {
        $(".site-footer .textwidget #nlpopup").fadeOut().removeClass("active");
        $('body').removeClass('nl-open')
      }
      openPopup = function() {
        $(".site-footer .textwidget #nlpopup").addClass('active')
        $('body').addClass('nl-open')
      }
    })

}(jQuery));
