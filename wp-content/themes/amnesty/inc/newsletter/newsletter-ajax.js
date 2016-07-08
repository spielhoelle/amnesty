jQuery(function($) {
  $('.mc_embed_signup').on('submit',function(e) {

	// Highjack the submit button, we will do it ourselves
	e.preventDefault();
    $('.mc_embed_signup .fa-circle-o-notch').css({'visibility': 'visible'})

	// uncomment next line & check console to see if button works
	// console.log('submit button worked!');

	// store all the form data in a variable
	var formData = $(this).serialize();

	// Let's make the call!
	// Replace the path to your own endpoint!
    $.getJSON('/wp-content/themes/amnesty/inc/newsletter/mc-endpoint.php', formData ,function(data) {
			// uncomment next line to see your data output in console
			console.log(data);

			// opt in mail out
			if(data.status === 'pending') {
				// Let us know!
		        $('.mc_embed_signup .fa-circle-o-notch').css({'visibility': 'hidden'})
		        $('.mc_embed_signup').append('<div class="mc4wp-success">Bitte check dein Postfach.<br/>Wir haben dir eine Bestätigungsmail gesendet...</div>')
			} else {
				// Otherwise tell us why it didn't
		        $('.mc_embed_signup .fa-circle-o-notch').css({'visibility': 'hidden'})
		        $('.mc_embed_signup').append('<div class="wpcf7-mail-sent-ng">Ooops, da gab es wohl ein Problem. Versuch es doch bitte später noch einmal.</div>')
		        console.log("Error:", data);
			}
		});
	});
});
