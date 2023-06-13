<?php

	// load in mailchimp library
	include('./MailChimp.php');

	// namespace defined in MailChimp.php
	use \DrewM\MailChimp\MailChimp;

	// connect to mailchimp
  $MailChimp = new MailChimp('6eefb8c45027467a39f2da3061ab698c-us13'); // put your API key here
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
									'status'            => 'pending',
									'update_existing'   => true, // YES, update old subscribers!
							));
	echo json_encode($result);

