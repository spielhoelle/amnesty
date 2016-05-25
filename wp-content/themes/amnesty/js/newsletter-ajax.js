(function($) {
    // *** MAILCHIMP AJAX SIGNUP WITH SWEET ALERTS ***
    ajaxMailChimpForm($("#mc-embedded-subscribe-form-small"));

    // Turn the given MailChimp form into an ajax version of it.
    // If resultElement is given, the subscribe result is set as html to
    // that element.
      function ajaxMailChimpForm($form) {
        // Hijack the submission. We'll submit the form manually.
        $form.submit(function(e) {
            e.preventDefault();
            if (!isValidEmail($form)) {
                $val({
                    title: "A valid email address must be provided!",
                    allowOutsideClick: true,
                    allowEscapeKey: true,
                    type: 'error'
                });
            } else {
                $val({
                    title: "Subscribing...",
                    allowOutsideClick: true,
                    allowEscapeKey: true,
                    showConfirmButton: false
                });
                submitSubscribeForm($form);
            }
        });
    }

    // Validate the email address in the form
    function isValidEmail($form) {
        // If email is empty, show error message.
        // contains just one @
        var email = $form.find("input[type='email']").val();
        if (!email || !email.length) {
            return false;
        } else if (email.indexOf("@") == -1) {
            return false;
        }
        return true;
    }

    // Submit the form with an ajax/jsonp request.
    // Based on http://stackoverflow.com/a/15120409/215821
    function submitSubscribeForm($form) {
        $.ajax({
            type: "GET",
            url: $form.attr("action"),
            data: $form.serialize(),
            cache: false,
            dataType: "jsonp",
            jsonp: "c", // trigger MailChimp to return a JSONP response
            contentType: "application/json; charset=utf-8",
            error: function(error) {
                // According to jquery docs, this is never called for cross-domain JSONP requests
            },
            success: function(data) {
                $('.sweet-overlay').hide();
                $('.sweet-alert').hide();
                if (data.result != "success") {
                    var message = data.msg || $val({
                        title: "Sorry",
                        text: "Unable to subscribe. Please try again later.",
                        allowOutsideClick: true,
                        allowEscapeKey: true,
                        type: "error"
                    });
                    $val({
                        title: (data.msg.replace(/(<([^>]+)>(.*?)<([^>]+)>)/, "")),
                        allowOutsideClick: true,
                        allowEscapeKey: true,
                        type: 'info'
                    }); //strips out the html from the message
                } else {
                    $val({
                        title: "Thank you!",
                        text: "You must confirm the subscription in your inbox. Please check your junk mail if it does not appear after 30mins.",
                        allowOutsideClick: true,
                        allowEscapeKey: true,
                        type: 'success'
                    });
                    $('#signup_content').hide();
                    $.cookie('name', 'hide_float_subscription_status_year', {
                        expires: 365,
                        path: '/'
                    });
                }
                $('.email_input').val('');
            }
        });
    }

    // *** END AJAX SIGNUP ***
}(jQuery));
