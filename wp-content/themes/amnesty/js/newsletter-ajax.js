jQuery(function($) {
  $('#mc_embed_signup').on('submit',function(e) {
    $('#mc_embed_signup .fa-circle-o-notch').css({'visibility': 'visible'})
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
		        $('#mc_embed_signup .fa-circle-o-notch').css({'visibility': 'hidden'})
		        $('#mc_embed_signup').append('<div class="mc4wp-success">Willkommen auf der Liste!<br/> Du wirst bald von uns hören.</div>')
			} else {
				// Otherwise tell us why it didn't
		        $('#mc_embed_signup .fa-circle-o-notch').css({'visibility': 'hidden'})
		        $('#mc_embed_signup').append('<div class="wpcf7-mail-sent-ng">Oops, da gab es wohl ein Problem. Versuch es bitte später noch einmal.</div>')
		        console.log("Error:", data);
			}
		});
	});
});
