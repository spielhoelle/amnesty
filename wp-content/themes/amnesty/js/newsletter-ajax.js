jQuery(function($) {
  $('#mc_embed_signup').on('submit',function(e) {
    $('#mc_embed_signup .fa-spinner').css({'visibility': 'visible'})
    // Highjack the submit button, we will do it ourselves
		e.preventDefault();
		// uncomment next line & check console to see if button works
		// store all the form data in a variable
		var formData = $(this).serialize();
		// Let's make the call!
		// Replace the path to your own endpoint!
    $.getJSON('wp-content/themes/amnesty/inc/mc-endpoint.php', formData ,function(data) {
			// uncomment next line to see your data output in console
			console.log(data);

			// If it worked...
			if(data.status === 'subscribed') {
				// Let us know!
				alert('Thanks!');
			} else {
				// Otherwise tell us why it didn't
				alert("oops error: " + data.detail);
        console.log(data);
			}
		});
	});
});
