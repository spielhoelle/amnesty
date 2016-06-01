<?php

	// load in mailchimp library
	include('./MailChimp.php');

	// namespace defined in MailChimp.php
	use \DrewM\MailChimp\MailChimp;

	// connect to mailchimp
  $MailChimp = new MailChimp('8ac0f4fea764ddd861b79c60b3228da8-us13'); // put your API key here
  $list = '014f2b7f68'; // put your list ID here
	$email = $_GET['EMAIL']; // Get email address from form
	$id = md5(strtolower($email)); // Encrypt the email address
	// setup th merge fields
	$mergeFields = array(
		// *** YOUR FIELDS GO HERE ***
		);

	// remove empty merge fields
	$mergeFields = array_filter($mergeFields);

	$result = $MailChimp->put("lists/$list/members/$id", array(
									'email_address'     => $email,
									'status'            => 'subscribed',
									'update_existing'   => true, // YES, update old subscribers!
							));
	echo json_encode($result);
